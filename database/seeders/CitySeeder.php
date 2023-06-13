<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("市区の作成を開始します...");
        $stationCompanyFileObject = new \SplFileObject(__DIR__ . '/data/city.csv');
        $stationCompanyFileObject->setFlags(
            \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($stationCompanyFileObject as $key => $row) {
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            City::create([
                'prefecture_id' => trim($enc_line[2]),
                'name' => trim($enc_line[1]),
                'city_number' => trim($enc_line[0]),
            ]);
            $count++;
        }

        $this->command->info("市区を{$count}件、作成しました。");
    }
}
