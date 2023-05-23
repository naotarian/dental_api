<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StationLine;

class StationLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("路線の作成を開始します...");
        $stationLineFileObject = new \SplFileObject(__DIR__ . '/data/line.csv');
        $stationLineFileObject->setFlags(
            \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($stationLineFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            StationLine::create([
                'line_code' => trim($enc_line[0]),
                'company_code' => trim($enc_line[1]),
                'line_name' => trim($enc_line[2]),
                'line_name_kana' => trim($enc_line[3]),
            ]);
            $count++;
        }

        $this->command->info("路線を{$count}件、作成しました。");
    }
}
