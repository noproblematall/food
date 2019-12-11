<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstName' => 'my',
            'lastName' => 'admin',
            'mobile' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Hihome@admin_2019'),
            'role_id' => 1,
            'mobile_verified' => true,
            'status_id' => 1,
        ]);
        $faker = Faker::create();
    	foreach (range(1,25) as $index) {
	        DB::table('users')->insert([
                'firstName' => $faker->firstName(),
                'lastName' => $faker->lastName,
                'mobile' => $faker->e164PhoneNumber,
	            'email' => $faker->email,
                'password' => bcrypt('111'),
                'role_id' => 2,
                'host_id' => $faker->unique()->numberBetween($min = 1, $max = 25),
                'mobile_verified' => $faker->randomElement($array = array (true, false)),
                'status_id' => $faker->numberBetween($min = 1, $max = 3),
                'gender' => $faker->randomElement($array = array('male', 'female')),
                'city' => $faker->city,
	        ]);
	    }
    	foreach (range(1,25) as $index) {
	        DB::table('users')->insert([
                'firstName' => $faker->firstName(),
                'lastName' => $faker->lastName,
                'mobile' => $faker->e164PhoneNumber,
	            'email' => $faker->email,
                'password' => bcrypt('111'),
                'role_id' => 3,
                'host_id' => null,
                'mobile_verified' => $faker->randomElement($array = array (true, false)),
                'status_id' => $faker->numberBetween($min = 1, $max = 3),
                'gender' => $faker->randomElement($array = array('male', 'female')),
                'city' => $faker->city,
	        ]);
	    } 
    }
}
