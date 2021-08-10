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
        $lat=['36.7764','35.6969','36.3650','36.4722','35.5500','36.1900','34.6667','36.9000','35.2000','34.8500',
        '35.4000','35.3667','36.7511','34.8828','36.0667','31.6333','36.8667','36.2864','36.1647','35.7058','35.9333',
        '36.2675','36.7169','33.3683','33.8000','31.9500','36.8206','35.7372','34.8303','36.4619','32.4833','35.4000',
        '35.4167','35.8706','33.6831','22.7850','35.6072','36.3783','27.8742','27.6753','36.7594','36.7669','36.5942',
        '26.5080','33.2678','35.3044','36.2583','36.4481'];
        $long=[
            '3.0586','-0.6331','6.6147','2.8333','6.1667','5.4100','3.2500','7.7667','-0.6333','5.7333','8.1167','1.3167'
            ,'5.0642','-1.3167','4.7667','-2.2000','6.9000','7.9511','1.3317','4.5419','0.0903','2.7500','4.0497','6.8675',
            '2.8650','5.3167','5.7667','0.5558','0.1517','7.4258','3.6667','0.1333','7.1333','7.1150','1.0192','5.5228','1.8106'
            ,'3.8925','-0.2939','-8.1286','3.4728','8.3136','2.4430','8.4829','-0.3111','-1.1400','1.9583','6.2622'
        ];
        $address = ['Algiers','Oran','Constantine','Blida','Batna','Sétif','Djelfa','Annaba','Sidi','Bel Abbès',
'Biskra','Tébessa','Tiaret','Bejaïa','Tlemcen','Bordj Bou Arreridj','Béchar','Skikda','Souk Ahras','Chlef','M’Sila',
'Mostaganem','Médéa','Tizi Ouzou','El Oued','Laghouat','Ouargla','Jijel','Relizane','Saïda','Guelma','Ghardaïa','Mascara',
'Khenchela','Oum el Bouaghi','El Bayadh','Tamanrasset','Tissemsilt','Bouira','Adrar','Tindouf','Boumerdes','El Tarf',
'Tipasa','Illizi','Naama','Aïn Temouchent','Aïn Defla','Mila'
        ];
        $users = ['0053736b-a41a-464f-b571-cdf1137716c9','5f5ab45b-2505-443a-8bf8-ca7bb8a91f82','166af13b-ed7b-4c0d-b5cd-0d6e32bc43ad'];
        for ($i=0; $i < 10000; $i++) {
        $number = rand(0,47);
        $customer = new Customer;
         $customer->name = Str::random(10);
         $customer->email = Str::random(10).'@gmail.com';
         $customer->phone = $nb[rand(0,2)].rand(10000000, 99999900);
         $customer->address = $address[$number];
         $customer->type = $type[rand(0,2)];
         $customer->user_id = $users[rand(0,2)];
         $customer->latitude = $lat[$number];
         $customer->longitude = $long[$number];
         $customer->save(); 
        }
    }
}
