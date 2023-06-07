<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Prefecture;

class RegionPrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = ['北海道・東北', '関東', '甲信越・北陸', '東海', '関西', '四国', '中国', '九州・沖縄'];
        foreach ($regions as $region) {
            Region::create([
                'region_name' => $region
            ]);
        }

        $prefectures = [
            ['name' => '北海道', 'region_id' => 1, 'prefecture_number' => 1],
            ['name' => '青森県', 'region_id' => 1, 'prefecture_number' => 2],
            ['name' => '岩手県', 'region_id' => 1, 'prefecture_number' => 3],
            ['name' => '宮城県', 'region_id' => 1, 'prefecture_number' => 4],
            ['name' => '秋田県', 'region_id' => 1, 'prefecture_number' => 5],
            ['name' => '山形県', 'region_id' => 1, 'prefecture_number' => 6],
            ['name' => '福島県', 'region_id' => 1, 'prefecture_number' => 7],
            ['name' => '茨城県', 'region_id' => 2, 'prefecture_number' => 8],
            ['name' => '栃木県', 'region_id' => 2, 'prefecture_number' => 9],
            ['name' => '群馬県', 'region_id' => 2, 'prefecture_number' => 10],
            ['name' => '埼玉県', 'region_id' => 2, 'prefecture_number' => 11],
            ['name' => '千葉県', 'region_id' => 2, 'prefecture_number' => 12],
            ['name' => '東京都', 'region_id' => 2, 'prefecture_number' => 13],
            ['name' => '神奈川県', 'region_id' => 2, 'prefecture_number' => 14],
            ['name' => '新潟県', 'region_id' => 3, 'prefecture_number' => 15],
            ['name' => '富山県', 'region_id' => 3, 'prefecture_number' => 16],
            ['name' => '石川県', 'region_id' => 3, 'prefecture_number' => 17],
            ['name' => '福井県', 'region_id' => 3, 'prefecture_number' => 18],
            ['name' => '山梨県', 'region_id' => 3, 'prefecture_number' => 19],
            ['name' => '長野県', 'region_id' => 3, 'prefecture_number' => 20],
            ['name' => '岐阜県', 'region_id' => 4, 'prefecture_number' => 21],
            ['name' => '静岡県', 'region_id' => 4, 'prefecture_number' => 22],
            ['name' => '愛知県', 'region_id' => 4, 'prefecture_number' => 23],
            ['name' => '三重県', 'region_id' => 4, 'prefecture_number' => 24],
            ['name' => '滋賀県', 'region_id' => 5, 'prefecture_number' => 25],
            ['name' => '京都府', 'region_id' => 5, 'prefecture_number' => 26],
            ['name' => '大阪府', 'region_id' => 5, 'prefecture_number' => 27],
            ['name' => '兵庫県', 'region_id' => 5, 'prefecture_number' => 28],
            ['name' => '奈良県', 'region_id' => 5, 'prefecture_number' => 29],
            ['name' => '和歌山県', 'region_id' => 5, 'prefecture_number' => 30],
            ['name' => '鳥取県', 'region_id' => 7, 'prefecture_number' => 31],
            ['name' => '島根県', 'region_id' => 7, 'prefecture_number' => 32],
            ['name' => '岡山県', 'region_id' => 7, 'prefecture_number' => 33],
            ['name' => '広島県', 'region_id' => 7, 'prefecture_number' => 34],
            ['name' => '山口県', 'region_id' => 7, 'prefecture_number' => 35],
            ['name' => '徳島県', 'region_id' => 6, 'prefecture_number' => 36],
            ['name' => '香川県', 'region_id' => 6, 'prefecture_number' => 37],
            ['name' => '愛媛県', 'region_id' => 6, 'prefecture_number' => 38],
            ['name' => '高知県', 'region_id' => 6, 'prefecture_number' => 39],
            ['name' => '福岡県', 'region_id' => 8, 'prefecture_number' => 40],
            ['name' => '佐賀県', 'region_id' => 8, 'prefecture_number' => 41],
            ['name' => '長崎県', 'region_id' => 8, 'prefecture_number' => 42],
            ['name' => '熊本県', 'region_id' => 8, 'prefecture_number' => 43],
            ['name' => '大分県', 'region_id' => 8, 'prefecture_number' => 44],
            ['name' => '宮崎県', 'region_id' => 8, 'prefecture_number' => 45],
            ['name' => '鹿児島県', 'region_id' => 8, 'prefecture_number' => 46],
            ['name' => '沖縄県', 'region_id' => 8, 'prefecture_number' => 47],
        ];
        foreach ($prefectures as $prefecture) {
            Prefecture::create([
                'name' => $prefecture['name'],
                'prefecture_number' => $prefecture['prefecture_number'],
                'region_id' => $prefecture['region_id'],
            ]);
        }
    }
}
