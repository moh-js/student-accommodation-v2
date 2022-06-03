<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockSideRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $gender_id = 1 male
        // $gender_id = 2 female

        $blocks = [
            [
                'name' => '6A', 'sides' => [
                    [
                        'name' => '6A' ,'gender_id' => 1, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 280
                        ]
                    ]
                ]
            ], [
                'name' => '6B', 'sides' => [
                    [
                        'name' => '6B' ,'gender_id' => 1, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 280
                        ]
                    ]
                ]
            ], [
                'name' => '8C', 'sides' => [
                    [
                        'name' => 'A', 'gender_id' => 1, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 180
                        ]
                    ], [
                        'name' => 'B', 'gender_id' => 1, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 180
                        ]
                    ]
                ]
            ], [
                'name' => '8D', 'sides' => [
                    [
                        'name' => 'A', 'gender_id' => 2, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 180
                        ]
                    ], [
                        'name' => 'B', 'gender_id' => 2, 'rooms' => [
                            'capacity' => 8, 'no_of_rooms' => 180
                        ]
                    ]
                ]
            ]
        ];

        foreach ($blocks as $block) {
            $blockModel = Block::firstOrCreate([
                'name' => $block['name']
            ]);

            echo "Block {$block['name']} created \n";

            foreach ($block['sides'] as $side) {
                $sideModel = $blockModel->sides()->firstOrCreate([
                    'name' => $side['name'],
                    'gender_id' => $side['gender_id']
                ]);

                echo "Side {$side['name']} of $sideModel->name created \n";

                for ($i=100; $i < $side['rooms']['no_of_rooms']; $i++) {
                    $sideModel->rooms()->firstOrCreate([
                        'name' => $i,
                        'capacity' => $side['rooms']['capacity']
                    ]);
                }
            }
        }
    }
}
