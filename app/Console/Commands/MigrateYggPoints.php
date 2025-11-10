<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\YggPoint;

class MigrateYggPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:ygg-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra pontos de doações de vote_points para ygg_points baseado no histórico de transações';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migração de Ygg Points...');
        
        // Buscar todas as transações pagas
        $transactions = Transaction::where('status', 'paid')
            ->orderBy('user_id')
            ->orderBy('created_at')
            ->get();
        
        if ($transactions->isEmpty()) {
            $this->info('Nenhuma transação paga encontrada. Nada a migrar.');
            return 0;
        }
        
        $this->info('Encontradas ' . $transactions->count() . ' transações pagas.');
        
        // Agrupar transações por usuário
        $userTransactions = $transactions->groupBy('user_id');
        
        $bar = $this->output->createProgressBar($userTransactions->count());
        $bar->start();
        
        $totalPointsMigrated = 0;
        $usersUpdated = 0;
        
        foreach ($userTransactions as $userId => $userTxs) {
            // Calcular total de pontos das doações deste usuário
            $totalPoints = $userTxs->sum('points');
            
            // Criar ou atualizar registro de Ygg Points
            YggPoint::updateOrCreate(
                ['user_id' => $userId],
                ['points' => $totalPoints]
            );
            
            $totalPointsMigrated += $totalPoints;
            $usersUpdated++;
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info('✓ Migração concluída!');
        $this->info('Usuários atualizados: ' . $usersUpdated);
        $this->info('Total de Ygg Points migrados: ' . number_format($totalPointsMigrated));
        
        $this->newLine();
        $this->warn('IMPORTANTE: Os pontos foram COPIADOS para ygg_points.');
        $this->warn('Os vote_points originais NÃO foram removidos.');
        $this->warn('Certifique-se de que o sistema agora usa YggPoint::getPoints() para doações.');
        
        return 0;
    }
}
