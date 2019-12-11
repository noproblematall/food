<?php

use Illuminate\Database\Seeder;
use App\Host;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,25) as $index) {
	        DB::table('hosts')->insert([
                'nameId' => '@'.$faker->name,
                'aboutYou' => $faker->text,
                'status' => $faker->randomElement($array = array (true, false)),
	        ]);
	    }
    }
}
