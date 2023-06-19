<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('staff_colors')->truncate();
        DB::table('regions')->truncate();
        DB::table('prefectures')->truncate();
        DB::table('users')->truncate();
        DB::table('station_companies')->truncate();
        DB::table('station_lines')->truncate();
        DB::table('stations')->truncate();
        DB::table('medical_parent_categories')->truncate();
        DB::table('medical_children_categories')->truncate();
        DB::table('day_of_weeks')->truncate();

        $this->call(GuestSeeder::class);
        $this->call(StationCompanySeeder::class);
        $this->call(StationLineSeeder::class);
        $this->call(StationSeeder::class);
        $this->call(MedicalParentCategorySeeder::class);
        $this->call(MedicalChildrenCategorySeeder::class);
        $this->call(StaffColorSeeder::class);
        $this->call(RegionPrefectureSeeder::class);
        $this->call(DayOfWeekSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // $this->call([
        //     StationCompanySeeder::class,
        //     StationLineSeeder::class,
        //     StationSeeder::class,
        //     MedicalParentCategorySeeder::class,
        //     MedicalChildrenCategorySeeder::class,
        //     StaffColorSeeder::class
        // ]);
    }
}
