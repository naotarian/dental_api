<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalParentCategory;

class MedicalParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => '治療', 'display_order' => 1],
            ['title' => '矯正', 'display_order' => 2],
            ['title' => '検診', 'display_order' => 3],
            ['title' => 'その他', 'display_order' => 4],
        ];
        foreach ($data as $d) {
            MedicalParentCategory::create(['title' => $d['title'], 'display_order' => $d['display_order']]);
        }
    }
}
