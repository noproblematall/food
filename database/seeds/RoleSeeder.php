<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['type' => 'admin']);
        Role::create(['type' => 'host']);
        Role::create(['type' => 'guest']);
    }
}
