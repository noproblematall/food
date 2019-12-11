<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['type' => 'Approved']);
        Status::create(['type' => 'Pending']);
        Status::create(['type' => 'Rejected']);
        Status::create(['type' => 'Suspended']);
    }
}
