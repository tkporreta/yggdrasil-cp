<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RouletteItem;
use App\Models\RouletteSetting;

class RouletteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar configurações padrão
        RouletteSetting::create([
            'spin_cost' => 100,
            'is_active' => true
        ]);

        // Criar itens de exemplo para a roleta
        $items = [
            [
                'name' => 'Poção de Cura',
                'item_id' => 501,
                'quantity' => 10,
                'probability' => 40,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Poção de Mana',
                'item_id' => 502,
                'quantity' => 10,
                'probability' => 40,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Cash Points',
                'item_id' => 0, // ID especial para Cash Points
                'quantity' => 50,
                'probability' => 30,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Elunium',
                'item_id' => 985,
                'quantity' => 5,
                'probability' => 20,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Oridecon',
                'item_id' => 984,
                'quantity' => 5,
                'probability' => 20,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Ticket VIP 3 Dias',
                'item_id' => 12900,
                'quantity' => 1,
                'probability' => 10,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Old Card Album',
                'item_id' => 616,
                'quantity' => 1,
                'probability' => 5,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Ticket VIP 7 Dias',
                'item_id' => 12901,
                'quantity' => 1,
                'probability' => 3,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Old Purple Box',
                'item_id' => 617,
                'quantity' => 1,
                'probability' => 2,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Mega Prêmio Cash',
                'item_id' => 0,
                'quantity' => 500,
                'probability' => 1,
                'image' => null,
                'is_active' => true
            ]
        ];

        foreach ($items as $item) {
            RouletteItem::create($item);
        }
    }
}

