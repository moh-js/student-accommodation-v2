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

        Block::query()->delete();

        $blocks = [
            [
                'name' => 'Block 6A', 'sides' => [
                    [
                        'name' => '6A' ,'gender_id' => 1, 'rooms' => [
                            [ 'capacity' => 8, 'name' => 'G01' ], 
                            [ 'capacity' => 8, 'name' => 'G02' ], 
                            [ 'capacity' => 8, 'name' => 'G03' ], 
                            [ 'capacity' => 8, 'name' => 'G04' ], 
                            [ 'capacity' => 8, 'name' => 'G05' ], 
                            [ 'capacity' => 8, 'name' => 'G06' ], 
                            [ 'capacity' => 8, 'name' => 'G07' ], 
                            [ 'capacity' => 8, 'name' => 'G08' ], 
                            [ 'capacity' => 8, 'name' => 'G09' ], 
                            [ 'capacity' => 8, 'name' => 'G10' ], 
                            [ 'capacity' => 8, 'name' => 'G11' ], 
                            [ 'capacity' => 8, 'name' => 'G12' ], 
                            [ 'capacity' => 8, 'name' => 'G13' ], 
                            [ 'capacity' => 8, 'name' => 'G14' ], 
                            [ 'capacity' => 8, 'name' => 'G15' ], 
                            [ 'capacity' => 8, 'name' => 'G16' ], 
                            [ 'capacity' => 8, 'name' => 'G17' ], 
                            [ 'capacity' => 8, 'name' => 'G18' ], 
                            [ 'capacity' => 8, 'name' => 'G19' ], 
                            [ 'capacity' => 8, 'name' => 'G20' ], 
                            [ 'capacity' => 8, 'name' => 'G21' ], 
                            [ 'capacity' => 8, 'name' => 'G22' ], 
                            [ 'capacity' => 8, 'name' => 'G23' ], 
                            [ 'capacity' => 8, 'name' => 'G24' ], 
                            [ 'capacity' => 6, 'name' => 'G25' ], 
                            [ 'capacity' => 8, 'name' => '101' ], 
                            [ 'capacity' => 8, 'name' => '102' ], 
                            [ 'capacity' => 8, 'name' => '103' ], 
                            [ 'capacity' => 8, 'name' => '104' ], 
                            [ 'capacity' => 8, 'name' => '105' ], 
                            [ 'capacity' => 8, 'name' => '106' ], 
                            [ 'capacity' => 8, 'name' => '107' ], 
                            [ 'capacity' => 8, 'name' => '108' ], 
                            [ 'capacity' => 8, 'name' => '109' ], 
                            [ 'capacity' => 8, 'name' => '110' ], 
                            [ 'capacity' => 8, 'name' => '111' ], 
                            [ 'capacity' => 8, 'name' => '112' ], 
                            [ 'capacity' => 8, 'name' => '113' ], 
                            [ 'capacity' => 8, 'name' => '114' ], 
                            [ 'capacity' => 8, 'name' => '115' ], 
                            [ 'capacity' => 8, 'name' => '116' ], 
                            [ 'capacity' => 8, 'name' => '117' ], 
                            [ 'capacity' => 8, 'name' => '118' ], 
                            [ 'capacity' => 8, 'name' => '119' ], 
                            [ 'capacity' => 8, 'name' => '120' ], 
                            [ 'capacity' => 8, 'name' => '121' ], 
                            [ 'capacity' => 8, 'name' => '122' ], 
                            [ 'capacity' => 8, 'name' => '123' ], 
                            [ 'capacity' => 8, 'name' => '124' ], 
                            [ 'capacity' => 8, 'name' => '125' ], 
                            [ 'capacity' => 8, 'name' => '126' ], 
                            [ 'capacity' => 6, 'name' => '127' ], 
                            [ 'capacity' => 8, 'name' => '201' ], 
                            [ 'capacity' => 8, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 8, 'name' => '206' ], 
                            [ 'capacity' => 8, 'name' => '207' ], 
                            [ 'capacity' => 8, 'name' => '208' ], 
                            [ 'capacity' => 8, 'name' => '209' ], 
                            [ 'capacity' => 8, 'name' => '210' ], 
                            [ 'capacity' => 8, 'name' => '211' ], 
                            [ 'capacity' => 8, 'name' => '212' ], 
                            [ 'capacity' => 8, 'name' => '213' ], 
                            [ 'capacity' => 8, 'name' => '214' ], 
                            [ 'capacity' => 8, 'name' => '215' ], 
                            [ 'capacity' => 8, 'name' => '216' ], 
                            [ 'capacity' => 8, 'name' => '217' ], 
                            [ 'capacity' => 8, 'name' => '218' ], 
                            [ 'capacity' => 8, 'name' => '219' ], 
                            [ 'capacity' => 8, 'name' => '220' ], 
                            [ 'capacity' => 8, 'name' => '221' ], 
                            [ 'capacity' => 8, 'name' => '222' ], 
                            [ 'capacity' => 8, 'name' => '223' ], 
                            [ 'capacity' => 8, 'name' => '224' ], 
                            [ 'capacity' => 8, 'name' => '225' ], 
                            [ 'capacity' => 8, 'name' => '226' ], 
                            [ 'capacity' => 6, 'name' => '227' ], 
                        ]
                    ]
                ]
            ], [
                'name' => 'Block 6B', 'sides' => [
                    [
                        'name' => '6B' ,'gender_id' => 1, 'rooms' => [
                            [ 'capacity' => 4, 'name' => '101' ], 
                            [ 'capacity' => 8, 'name' => '102' ], 
                            [ 'capacity' => 8, 'name' => '103' ], 
                            [ 'capacity' => 8, 'name' => '104' ], 
                            [ 'capacity' => 8, 'name' => '105' ], 
                            [ 'capacity' => 8, 'name' => '106' ], 
                            [ 'capacity' => 8, 'name' => '107' ], 
                            [ 'capacity' => 8, 'name' => '109' ], 
                            [ 'capacity' => 8, 'name' => '110' ], 
                            [ 'capacity' => 8, 'name' => '111' ], 
                            [ 'capacity' => 8, 'name' => '112' ], 
                            [ 'capacity' => 8, 'name' => '113' ], 
                            [ 'capacity' => 8, 'name' => '114' ], 
                            [ 'capacity' => 8, 'name' => '115' ], 
                            [ 'capacity' => 8, 'name' => '116' ], 
                            [ 'capacity' => 8, 'name' => '117' ], 
                            [ 'capacity' => 8, 'name' => '118' ], 
                            [ 'capacity' => 8, 'name' => '119' ], 
                            [ 'capacity' => 8, 'name' => '120' ], 
                            [ 'capacity' => 8, 'name' => '122' ], 
                            [ 'capacity' => 8, 'name' => '123' ], 
                            [ 'capacity' => 8, 'name' => '124' ], 
                            [ 'capacity' => 8, 'name' => '125' ], 
                            [ 'capacity' => 8, 'name' => '201' ], 
                            [ 'capacity' => 8, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 8, 'name' => '206' ], 
                            [ 'capacity' => 8, 'name' => '207' ], 
                            [ 'capacity' => 8, 'name' => '209' ], 
                            [ 'capacity' => 8, 'name' => '210' ], 
                            [ 'capacity' => 8, 'name' => '211' ], 
                            [ 'capacity' => 8, 'name' => '212' ], 
                            [ 'capacity' => 8, 'name' => '213' ], 
                            [ 'capacity' => 8, 'name' => '214' ], 
                            [ 'capacity' => 8, 'name' => '215' ], 
                            [ 'capacity' => 8, 'name' => '216' ], 
                            [ 'capacity' => 8, 'name' => '217' ], 
                            [ 'capacity' => 8, 'name' => '218' ], 
                            [ 'capacity' => 8, 'name' => '219' ], 
                            [ 'capacity' => 8, 'name' => '220' ], 
                            [ 'capacity' => 8, 'name' => '222' ], 
                            [ 'capacity' => 8, 'name' => '223' ], 
                            [ 'capacity' => 8, 'name' => '224' ], 
                            [ 'capacity' => 8, 'name' => '225' ], 
                            [ 'capacity' => 8, 'name' => '226' ], 
                            [ 'capacity' => 8, 'name' => '227' ], 
                            [ 'capacity' => 8, 'name' => '228' ], 
                            [ 'capacity' => 8, 'name' => '301' ], 
                            [ 'capacity' => 8, 'name' => '302' ], 
                            [ 'capacity' => 8, 'name' => '303' ], 
                            [ 'capacity' => 8, 'name' => '304' ], 
                            [ 'capacity' => 8, 'name' => '305' ], 
                            [ 'capacity' => 8, 'name' => '306' ], 
                            [ 'capacity' => 8, 'name' => '307' ], 
                            [ 'capacity' => 8, 'name' => '309' ], 
                            [ 'capacity' => 8, 'name' => '310' ], 
                            [ 'capacity' => 8, 'name' => '311' ], 
                            [ 'capacity' => 8, 'name' => '312' ], 
                            [ 'capacity' => 8, 'name' => '313' ], 
                            [ 'capacity' => 8, 'name' => '314' ], 
                            [ 'capacity' => 8, 'name' => '315' ], 
                            [ 'capacity' => 8, 'name' => '316' ], 
                            [ 'capacity' => 8, 'name' => '317' ], 
                            [ 'capacity' => 8, 'name' => '318' ], 
                            [ 'capacity' => 8, 'name' => '319' ], 
                            [ 'capacity' => 8, 'name' => '320' ], 
                            [ 'capacity' => 8, 'name' => '322' ], 
                            [ 'capacity' => 8, 'name' => '323' ], 
                            [ 'capacity' => 8, 'name' => '324' ], 
                            [ 'capacity' => 8, 'name' => '325' ], 
                            [ 'capacity' => 8, 'name' => '326' ], 
                            [ 'capacity' => 8, 'name' => '327' ], 
                            [ 'capacity' => 8, 'name' => '328' ], 
                        ]
                    ]
                ]
            ], [
                'name' => 'Block 8C', 'sides' => [
                    [
                        'name' => 'Side A', 'gender_id' => 2, 'rooms' => [
                            [ 'capacity' => 6, 'name' => '201' ], 
                            [ 'capacity' => 6, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 8, 'name' => '206' ], 
                            [ 'capacity' => 6, 'name' => '207' ], 
                            [ 'capacity' => 4, 'name' => 'CR 2' ],
                            [ 'capacity' => 6, 'name' => '301' ], 
                            [ 'capacity' => 6, 'name' => '302' ], 
                            [ 'capacity' => 8, 'name' => '303' ], 
                            [ 'capacity' => 8, 'name' => '304' ], 
                            [ 'capacity' => 8, 'name' => '305' ], 
                            [ 'capacity' => 8, 'name' => '306' ], 
                            [ 'capacity' => 6, 'name' => '307' ], 
                            [ 'capacity' => 4, 'name' => 'CR 3' ],
                            [ 'capacity' => 6, 'name' => '401' ], 
                            [ 'capacity' => 6, 'name' => '402' ], 
                            [ 'capacity' => 8, 'name' => '403' ], 
                            [ 'capacity' => 8, 'name' => '404' ], 
                            [ 'capacity' => 8, 'name' => '405' ], 
                            [ 'capacity' => 8, 'name' => '406' ], 
                            [ 'capacity' => 6, 'name' => '407' ], 
                            [ 'capacity' => 4, 'name' => 'CR 4' ],
                        ]
                    ], [
                        'name' => 'Side B', 'gender_id' => 2, 'rooms' => [
                            [ 'capacity' => 6, 'name' => '101' ], 
                            [ 'capacity' => 8, 'name' => '102' ], 
                            [ 'capacity' => 8, 'name' => '103' ], 
                            [ 'capacity' => 8, 'name' => '104' ], 
                            [ 'capacity' => 8, 'name' => '105' ], 
                            [ 'capacity' => 6, 'name' => '106' ], 
                            [ 'capacity' => 6, 'name' => '107' ], 
                            [ 'capacity' => 4, 'name' => 'CR 1' ],
                            [ 'capacity' => 6, 'name' => '201' ], 
                            [ 'capacity' => 8, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 6, 'name' => '206' ], 
                            [ 'capacity' => 6, 'name' => '207' ], 
                            [ 'capacity' => 4, 'name' => 'CR 2' ],
                            [ 'capacity' => 6, 'name' => '301' ], 
                            [ 'capacity' => 8, 'name' => '302' ], 
                            [ 'capacity' => 8, 'name' => '303' ], 
                            [ 'capacity' => 8, 'name' => '304' ], 
                            [ 'capacity' => 8, 'name' => '305' ], 
                            [ 'capacity' => 6, 'name' => '306' ], 
                            [ 'capacity' => 6, 'name' => '307' ], 
                            [ 'capacity' => 4, 'name' => 'CR 3' ],
                            [ 'capacity' => 6, 'name' => '401' ], 
                            [ 'capacity' => 8, 'name' => '402' ], 
                            [ 'capacity' => 8, 'name' => '403' ], 
                            [ 'capacity' => 8, 'name' => '404' ], 
                            [ 'capacity' => 8, 'name' => '405' ], 
                            [ 'capacity' => 6, 'name' => '406' ], 
                            [ 'capacity' => 6, 'name' => '407' ], 
                            [ 'capacity' => 4, 'name' => 'CR 4' ],
                        ]
                    ]
                ]
            ], [
                'name' => 'Block 8D', 'sides' => [
                    [
                        'name' => 'Side A', 'gender_id' => 2, 'rooms' => [
                            [ 'capacity' => 8, 'name' => '102' ], 
                            [ 'capacity' => 6, 'name' => '103' ], 
                            [ 'capacity' => 6, 'name' => '201' ], 
                            [ 'capacity' => 6, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 8, 'name' => '206' ], 
                            [ 'capacity' => 6, 'name' => '207' ], 
                            [ 'capacity' => 4, 'name' => 'CR 2' ],
                            [ 'capacity' => 6, 'name' => '301' ], 
                            [ 'capacity' => 6, 'name' => '302' ], 
                            [ 'capacity' => 8, 'name' => '303' ], 
                            [ 'capacity' => 8, 'name' => '304' ], 
                            [ 'capacity' => 8, 'name' => '305' ], 
                            [ 'capacity' => 8, 'name' => '306' ], 
                            [ 'capacity' => 6, 'name' => '307' ], 
                            [ 'capacity' => 4, 'name' => 'CR 3' ],
                            [ 'capacity' => 6, 'name' => '401' ], 
                            [ 'capacity' => 6, 'name' => '402' ], 
                            [ 'capacity' => 8, 'name' => '403' ], 
                            [ 'capacity' => 8, 'name' => '404' ], 
                            [ 'capacity' => 8, 'name' => '405' ], 
                            [ 'capacity' => 8, 'name' => '406' ], 
                            [ 'capacity' => 6, 'name' => '407' ], 
                            [ 'capacity' => 4, 'name' => 'CR 4' ],
                            [ 'capacity' => 6, 'name' => '501' ], 
                            [ 'capacity' => 6, 'name' => '502' ], 
                            [ 'capacity' => 8, 'name' => '503' ], 
                            [ 'capacity' => 8, 'name' => '504' ], 
                            [ 'capacity' => 8, 'name' => '505' ], 
                            [ 'capacity' => 8, 'name' => '506' ], 
                            [ 'capacity' => 6, 'name' => '507' ], 
                            [ 'capacity' => 4, 'name' => 'CR 5' ],
                        ]
                    ], [
                        'name' => 'Side B', 'gender_id' => 2, 'rooms' => [
                            [ 'capacity' => 6, 'name' => '101' ], 
                            [ 'capacity' => 8, 'name' => '102' ], 
                            [ 'capacity' => 6, 'name' => '103' ], 
                            [ 'capacity' => 4, 'name' => 'CR 1' ],
                            [ 'capacity' => 6, 'name' => '201' ], 
                            [ 'capacity' => 8, 'name' => '202' ], 
                            [ 'capacity' => 8, 'name' => '203' ], 
                            [ 'capacity' => 8, 'name' => '204' ], 
                            [ 'capacity' => 8, 'name' => '205' ], 
                            [ 'capacity' => 6, 'name' => '206' ], 
                            [ 'capacity' => 6, 'name' => '207' ], 
                            [ 'capacity' => 4, 'name' => 'CR 2' ],
                            [ 'capacity' => 6, 'name' => '301' ], 
                            [ 'capacity' => 8, 'name' => '302' ], 
                            [ 'capacity' => 8, 'name' => '303' ], 
                            [ 'capacity' => 8, 'name' => '304' ], 
                            [ 'capacity' => 8, 'name' => '305' ], 
                            [ 'capacity' => 6, 'name' => '306' ], 
                            [ 'capacity' => 6, 'name' => '307' ], 
                            [ 'capacity' => 4, 'name' => 'CR 3' ],
                            [ 'capacity' => 6, 'name' => '401' ], 
                            [ 'capacity' => 8, 'name' => '402' ], 
                            [ 'capacity' => 8, 'name' => '403' ], 
                            [ 'capacity' => 8, 'name' => '404' ], 
                            [ 'capacity' => 8, 'name' => '405' ], 
                            [ 'capacity' => 6, 'name' => '406' ], 
                            [ 'capacity' => 6, 'name' => '407' ], 
                            [ 'capacity' => 4, 'name' => 'CR 4' ],
                            [ 'capacity' => 6, 'name' => '501' ], 
                            [ 'capacity' => 8, 'name' => '502' ], 
                            [ 'capacity' => 8, 'name' => '503' ], 
                            [ 'capacity' => 8, 'name' => '504' ], 
                            [ 'capacity' => 8, 'name' => '505' ], 
                            [ 'capacity' => 6, 'name' => '506' ], 
                            [ 'capacity' => 6, 'name' => '507' ], 
                            [ 'capacity' => 4, 'name' => 'CR 5' ],
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

                foreach($side['rooms'] as $room) {
                    $sideModel->rooms()->firstOrCreate([
                        'name' => $room['name'],
                        'capacity' => $room['capacity']
                    ]);
                }
            }
        }
    }
}
