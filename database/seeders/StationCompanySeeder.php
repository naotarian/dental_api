<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StationCompany;

class StationCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("鉄道会社の作成を開始します...");
        $stationCompanyFileObject = new \SplFileObject(__DIR__ . '/data/company.csv');
        $stationCompanyFileObject->setFlags(
            \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($stationCompanyFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            StationCompany::create([
                'company_code' => trim($enc_line[0]),
                'company_name' => trim($enc_line[2]),
                'company_name_kana' => trim($enc_line[3]),
            ]);
            $count++;
        }

        $this->command->info("鉄道会社を{$count}件、作成しました。");
    }
}
