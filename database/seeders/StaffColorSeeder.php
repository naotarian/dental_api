<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaffColor;

class StaffColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            ['color_code' => '#EABEBF', 'color_name' => '薄ピンク'],
            ['color_code' => '#75CCE8', 'color_name' => 'ライトブルー'],
            ['color_code' => '#F7DB70', 'color_name' => '黄色'],
            ['color_code' => '#80BEAF', 'color_name' => '青緑'],
            ['color_code' => '#EE9C6A', 'color_name' => '暗オレンジ'],
            ['color_code' => '#A9998A', 'color_name' => '茶色'],
            ['color_code' => '#E57B87', 'color_name' => '濃ピンク'],
            ['color_code' => '#C8A8DA', 'color_name' => '薄紫'],
            ['color_code' => '#BBD5A6', 'color_name' => 'ライトグリーン'],
            ['color_code' => '#A5DEE5', 'color_name' => 'スカイブルー'],
        ];
        foreach ($colors as $color) {
            StaffColor::create([
                'color_code' => $color['color_code'],
                'color_name' => $color['color_name'],
            ]);
        }
    }
}
