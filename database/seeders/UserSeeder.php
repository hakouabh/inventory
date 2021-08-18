<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $longi=[
            -0.62728,-0.6641,-0.6521,-0.6237,-0.5801,-0.5732,-0.5667,-0.75612,0.7616,-0.7927,-0.7131,-0.70821,-0.70687

        ];
        $lati=[
            35.68872,35.6892,35.7004,35.6942,35.7284,35.7264,35.7308,35.73132,35.7389,35.752635,35.7214,35.72755,35.73097
        ];

        for ($i=0; $i < 10; $i++) {
            $number = rand(0,12);
            $longitude = (float) $longi[$number];
            $latitude = (float) $lati[$number];
            $nbr = rand(41,90);
            $radius = rand(0,2); // in miles

            $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * $nbr);
            $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * $nbr);
            $lat_min = $latitude - ($radius / $nbr);
            $lat_max = $latitude + ($radius / $nbr);

            $user = new User;
            $user->name = Str::random(10);
            $user->email = Str::random(10).'@gmail.com';
            $user->password =bcrypt('admin123');
            $user->latitude = $lat_min;
            $user->longitude = $lng_min;
            $user->save();
            
        }
    }
}
