<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\VotePoint;
use App\Models\YggPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    // Pacotes de doação disponíveis
    private $packages = [
        [
            'points' => 500,
            'amount' => 500, // R$ 5,00 em centavos
            'image' => '/img/yp-500.png',
            'popular' => false
        ],
        [
            'points' => 1000,
            'amount' => 1000, // R$ 10,00
            'image' => '/img/yp-1000.png',
            'popular' => false
        ],
        [
            'points' => 2500,
            'amount' => 2500, // R$ 25,00
            'image' => '/img/yp-2500.png',
            'popular' => true
        ],
        [
            'points' => 5000,
            'amount' => 5000, // R$ 50,00
            'image' => '/img/yp-5000.png',
            'popular' => false
        ],
        [
            'points' => 10000,
            'amount' => 10000, // R$ 100,00
            'image' => '/img/yp-10000.png',
            'popular' => false
        ],
        [
            'points' => 25000,
            'amount' => 25000, // R$ 250,00
            'image' => '/img/yp-25000.png',
            'popular' => false
        ],
    ];

    // Página de doações
    public function index(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $userId = session('user_id');
        $user = User::find($userId);
        $userPoints = YggPoint::getPoints($userId);

        // Buscar últimas transações do usuário
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('donation.index', [
            'packages' => $this->packages,
            'userPoints' => $userPoints,
            'user' => $user,
            'transactions' => $transactions
        ]);
    }

    // Criar cobrança no AbacatePay
    public function createPayment(Request $request)
    {
        if (!session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado.'
            ], 401);
        }

        $validated = $request->validate([
            'points' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        $apiKey = env('ABACATEPAY_API_KEY');
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Configuração de pagamento não encontrada.'
            ], 500);
        }

        try {
            // Criar cobrança no AbacatePay
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.abacatepay.com/v1/billing/create', [
                'frequency' => 'ONE_TIME',
                'methods' => ['PIX'],
                'products' => [
                    [
                        'externalId' => 'YGG-POINTS-' . $validated['points'],
                        'name' => $validated['points'] . ' Ygg Points',
                        'description' => 'Compra de ' . $validated['points'] . ' pontos Yggdrasil',
                        'quantity' => 1,
                        'price' => $validated['amount']
                    ]
                ],
                'returnUrl' => url('/account/ygg-points'),
                'completionUrl' => url('/account/ygg-points?success=true'),
                'metadata' => [
                    'user_id' => $userId,
                    'username' => $user->username,
                    'points' => $validated['points']
                ]
            ]);

            $data = $response->json();

            if (!$response->successful() || isset($data['error'])) {
                Log::error('AbacatePay API Error', ['response' => $data]);
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao criar cobrança: ' . ($data['error'] ?? 'Erro desconhecido')
                ], 500);
            }

            // Salvar transação no banco
            $transaction = Transaction::create([
                'user_id' => $userId,
                'billing_id' => $data['data']['id'],
                'amount' => $validated['amount'],
                'points' => $validated['points'],
                'status' => 'pending',
                'payment_url' => $data['data']['url']
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $data['data']['url'],
                'billing_id' => $data['data']['id'],
                'transaction_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Creation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar pagamento. Tente novamente.'
            ], 500);
        }
    }

    // Webhook do AbacatePay
    public function webhook(Request $request)
    {
        // Validar secret do webhook
        $webhookSecret = $request->query('webhookSecret');
        $configuredSecret = env('ABACATEPAY_WEBHOOK_SECRET');

        if ($webhookSecret !== $configuredSecret) {
            Log::warning('Invalid webhook secret', ['received' => $webhookSecret]);
            return response()->json(['error' => 'Invalid webhook secret'], 401);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        Log::info('Webhook received', ['event' => $event, 'data' => $data]);

        if ($event === 'billing.paid') {
            $this->handleBillingPaid($data);
        }

        return response()->json(['received' => true], 200);
    }

    private function handleBillingPaid($data)
    {
        $billingId = null;
        
        // Extrair billing_id dependendo do tipo de pagamento
        if (isset($data['billing']['id'])) {
            $billingId = $data['billing']['id'];
        } elseif (isset($data['pixQrCode']['id'])) {
            $billingId = $data['pixQrCode']['id'];
        }

        if (!$billingId) {
            Log::error('Billing ID not found in webhook data', ['data' => $data]);
            return;
        }

        $transaction = Transaction::where('billing_id', $billingId)->first();

        if (!$transaction) {
            Log::warning('Transaction not found for billing_id', ['billing_id' => $billingId]);
            return;
        }

        if ($transaction->status === 'paid') {
            Log::info('Transaction already processed', ['transaction_id' => $transaction->id]);
            return;
        }

        // Atualizar transação
        $transaction->update([
            'status' => 'paid',
            'payment_method' => $data['payment']['method'] ?? 'PIX',
            'paid_at' => now()
        ]);

        // Adicionar Ygg Points ao usuário (não Vote Points)
        YggPoint::addPoints($transaction->user_id, $transaction->points);

        Log::info('Payment processed successfully', [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user_id,
            'points' => $transaction->points
        ]);
    }

    // Admin - Gerenciar doações
    public function adminIndex(Request $request)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        // Filtros
        $query = Transaction::with('user');

        // Filtrar por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por data
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Buscar por usuário
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = [
            'total' => Transaction::count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'paid' => Transaction::where('status', 'paid')->count(),
            'cancelled' => Transaction::where('status', 'cancelled')->count(),
            'total_revenue' => Transaction::where('status', 'paid')->sum('amount') / 100, // converter de centavos para reais
            'total_points' => Transaction::where('status', 'paid')->sum('points'),
        ];

        return view('admin.donations.index', compact('transactions', 'stats'));
    }

    // Admin - Processar transação manualmente
    public function processTransaction(Request $request, $id)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $transaction = Transaction::findOrFail($id);

        // Verificar se já foi processada
        if ($transaction->status === 'paid') {
            return redirect()->route('admin.donations.index')
                ->with('error', 'Esta transação já foi processada.');
        }

        // Atualizar status para pago
        $transaction->update([
            'status' => 'paid',
            'payment_method' => 'PIX',
            'paid_at' => now()
        ]);

        // Adicionar Ygg Points ao usuário (não Vote Points)
        YggPoint::addPoints($transaction->user_id, $transaction->points);

        Log::info('Transaction manually processed by admin', [
            'transaction_id' => $transaction->id,
            'admin_user_id' => session('user_id'),
            'user_id' => $transaction->user_id,
            'points' => $transaction->points
        ]);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Transação #' . $transaction->id . ' processada com sucesso! ' . $transaction->points . ' pontos creditados.');
    }
}
