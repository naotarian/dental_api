<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DayOfWeek;

class DayOfWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => '月曜日'],
            ['name' => '火曜日'],
            ['name' => '水曜日'],
            ['name' => '木曜日'],
            ['name' => '金曜日'],
            ['name' => '土曜日'],
            ['name' => '日曜日'],
            ['name' => '祝日'],
        ];
        foreach ($data as $key => $d) {
            DayOfWeek::create([
                'name' => $d['name'],
                'number' => $key + 1,
                'alphabet' => $d['name'] === '祝日' ? 'holiday' : config('app.number_to_week')[$key],
            ]);
        }
    }
}
