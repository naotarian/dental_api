<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Station;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("駅データの作成を開始します...");
        $stationFileObject = new \SplFileObject(__DIR__ . '/data/station.csv');
        $stationFileObject->setFlags(
            \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($stationFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            Station::create([
                'station_code' => trim($enc_line[0]),
                'station_group_code' => trim($enc_line[1]),
                'station_name' => trim($enc_line[2]),
                'line_code' => trim($enc_line[5]),
            ]);
            $count++;
        }

        $this->command->info("駅データを{$count}件、作成しました。");
    }
}
