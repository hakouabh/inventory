<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Model\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $type=["Loyal customer","New customer","Dissatisfied Customer"];
        $nb=['07','06','05'];
        // $lat=['36.7764','35.6969','36.3650','36.4722','35.5500','36.1900','34.6667','36.9000','35.2000','34.8500',
        // '35.4000','35.3667','36.7511','34.8828','36.0667','31.6333','36.8667','36.2864','36.1647','35.7058','35.9333',
        // '36.2675','36.7169','33.3683','33.8000','31.9500','36.8206','35.7372','34.8303','36.4619','32.4833','35.4000',
        // '35.4167','35.8706','33.6831','22.7850','35.6072','36.3783','27.8742','27.6753','36.7594','36.7669','36.5942',
        // '26.5080','33.2678','35.3044','36.2583','36.4481'];
        // $long=[
        //     '3.0586','-0.6331','6.6147','2.8333','6.1667','5.4100','3.2500','7.7667','-0.6333','5.7333','8.1167','1.3167'
        //     ,'5.0642','-1.3167','4.7667','-2.2000','6.9000','7.9511','1.3317','4.5419','0.0903','2.7500','4.0497','6.8675',
        //     '2.8650','5.3167','5.7667','0.5558','0.1517','7.4258','3.6667','0.1333','7.1333','7.1150','1.0192','5.5228','1.8106'
        //     ,'3.8925','-0.2939','-8.1286','3.4728','8.3136','2.4430','8.4829','-0.3111','-1.1400','1.9583','6.2622'
        // ];
        $longi=[
            -0.62728,-0.6641,-0.6521,-0.6237,-0.5801,-0.5732,-0.5667,-0.75612,0.7616,-0.7927,-0.7131,-0.70821,-0.70687

        ];
        $lati=[
            35.68872,35.6892,35.7004,35.6942,35.7284,35.7264,35.7308,35.73132,35.7389,35.752635,35.7214,35.72755,35.73097
        ];
        $address = ['Algiers','Oran','Constantine','Blida','Batna','Sétif','Djelfa','Annaba','Sidi','Bel Abbès',
'Biskra','Tébessa','Tiaret','Bejaïa','Tlemcen','Bordj Bou Arreridj','Béchar','Skikda','Souk Ahras','Chlef','M’Sila',
'Mostaganem','Médéa','Tizi Ouzou','El Oued','Laghouat','Ouargla','Jijel','Relizane','Saïda','Guelma','Ghardaïa','Mascara',
'Khenchela','Oum el Bouaghi','El Bayadh','Tamanrasset','Tissemsilt','Bouira','Adrar','Tindouf','Boumerdes','El Tarf',
'Tipasa','Illizi','Naama','Aïn Temouchent','Aïn Defla','Mila'
        ];
        
        $users = [
            '02059ac2-a685-4a82-8cbe-0a472b0b391b','2c4d4cc1-b93e-472c-9208-d2fae9712744','7148964f-8cee-4202-8bab-c8045d976050','a6907f56-5185-400f-9fff-5ab4776a4517','9f16ad7c-e567-43bb-be8c-5b054ad97af7',
            '44736232-f2ba-43b8-a68a-28720113fd26','7d97084d-6834-49c2-99bf-d00f570bb493','6028b934-c6ee-48e6-a58f-d13dcaf769fd','ae43331f-bfcb-4a60-9317-880953f85208','4d38def4-f9a5-476c-9f26-1c22cb0b12ea'
        ]; 
        for ($i=0; $i < 100; $i++) {
        // $number = rand(0,1);
        // $number1 = rand(0,50);
        $number = rand(0,12);
        $longitude = (float) $longi[$number];
        $latitude = (float) $lati[$number];
        $nbr = rand(41,90);
        $radius = rand(0,2); // in miles

        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * $nbr);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * $nbr);
        $lat_min = $latitude - ($radius / $nbr);
        $lat_max = $latitude + ($radius / $nbr);
        $customer = new Customer;
         $customer->name = Str::random(10);
         $customer->email = Str::random(10).'@gmail.com';
         $customer->phone = $nb[rand(0,2)].rand(10000000, 99999900);
         $customer->address = $address[$number];
         $customer->type = $type[rand(0,2)];
         $customer->user_id = $users[rand(0,9)];
         //$customer->latitude = floatval($lat[$number]) - floatval("0.".$number1);
         //$customer->longitude = floatval($long[$number]) + floatval("0.".$number1);
         $customer->latitude = $lat_min;
         $customer->longitude = $lng_min;
         $customer->save(); 
        }
    }
}
