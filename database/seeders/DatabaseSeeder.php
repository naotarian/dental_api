<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(StationCompanySeeder::class);
        // $this->call(StationLineSeeder::class);
        // $this->call(StationSeeder::class);
        $this->call(MedicalParentCategorySeeder::class);
        $this->call(MedicalChildrenCategorySeeder::class);
    }
}
