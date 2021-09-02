<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use App\Model\Supplier;
use App\Model\Category;
use App\Model\Product;
class ProductTest extends TestCase
{

    use DatabaseTransactions;
    
    protected $product;

    public function setUp() :void {

        parent::setUp();

        $this->product = factory(Product::class)->create();

        $this->signIn();

    }

    public function a_user_can_create_a_product(){

        $data = [
            'user_id' => $this->user->id->string,
            'category_id' =>factory(Category::class)->create()->id,
            'supplier_id' => factory(Supplier::class)->create()->id,
            'product_name' =>'fake product',
            'product_code' => 156498798465165,
            'buying_price' => 2000,
            'selling_price' => 1000,
            'buying_date' => '01-09-2021' ,
            'product_quantity' => 10,
            'min_quantity' => 5 
        ];

        $response = $this->json('POST', '/api/products/store',$data);

        $response->assertStatus(200);
    }
    /** @test */
    public function a_user_can_get_all_products(){

        $response = $this->get('/api/products/index/'.$this->product->id->string);
        $response->assertStatus(200);

            // $response->assertJsonStructure(
            //     [
                    
            //                 'id',
            //                 'user_id',
            //                 'category_id',
            //                 'supplier_id',
            //                 'product_name',
            //                 'product_code',
            //                 'buying_price',
            //                 'selling_price',
            //                 'buying_date',
            //                 'product_quantity',
            //                 'min_quantity',
            //                 'image',
            //                 'created_at',
            //                 'updated_at'
                    
            //     ]
            // );

    }
}
