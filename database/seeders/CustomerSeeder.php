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
            '5aaf9076-410f-4654-aedd-914119078d4e',
'4fe71583-d1ca-45d2-a186-915b1b03c517',
'93726d14-df62-45b9-ab0b-3675eb112a88',
'b0f22f3a-cf6d-4bf9-bcc7-b6ba77644cdc',
'8a96f948-12cd-4853-bd81-aa9cb063c1ee',
'2663d324-491f-4824-a61f-a3e18c2056b4',
'04f7f004-cc47-4805-9fb5-ffefafd1d0d3',
'8397d83b-c1d8-4dc2-a655-2c845985aac4',
'd8b245a5-8493-4090-8400-706ea49ecfd0',
'e197c29d-4171-40f3-a14b-6550ce682389'

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
