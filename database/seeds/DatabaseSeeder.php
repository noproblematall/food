<?php

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
        $this->call(RoleSeeder::class);
        $this->call(HostSeeder::class);
        $this->call(StatusSeeder::class);
        // $this->call(FoodCategory::class);
        // $this->call(CitySeeder::class);
        // $this->call(PlaceCategory::class);
        $this->call(AdminSeeder::class);
        // $this->call(PhotoSeeder::class);
        // $this->call(WajbaSeeder::class);
        // $this->call(ReviewSeeder::class);
        // $this->call(DateSeeder::class);
        // $this->call(TimeSeeder::class);
    }
}
