<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Model\Product;

use App\Model\Customer;

use Illuminate\Foundation\Testing\DatabaseTransactions;



class OrderTest extends TestCase
{

    protected $product;
    use DatabaseTransactions;

    public function setUp() :void {

        parent::setUp();

        $this->product = factory(Product::class)->create();
        // create user and sign
        $this->signIn();

    }


    /** @test */

    public function a_user_can_add_product_to_cart(){
        // create user
        // create product

        // add product to cart
        $response = $this->json('GET', '/api/addToCart/'.$this->product->id->string);

        //check if the product is successfully added 
        $response->assertStatus(201);

        // add the same product to cart
        $response = $this->json('GET', '/api/addToCart/'.$this->product->id->string);

        //check if the quantity is incremented 
        $response->assertStatus(200);

        //add all to cart 
        for ($i=0; $i < $this->product->product_quantity -2 ; $i++) {
            $response = $this->json('GET', '/api/addToCart/'.$this->product->id->string);

            //check if the quantity is incremented 
            $response->assertStatus(200);
        }

        //try to add product to cart whene quantity is 0
        $response = $this->json('GET', '/api/addToCart/'.$this->product->id->string);

            //check if the message is out of stock 
            $response->assertStatus(404);
    }

    /** @test  */

    public function a_user_can_create_order(){

        //create user 
        // create product
        $product = factory(Product::class)->create([
            'user_id' => $this->user->id->string
        ]);
        //create customer 
        $customer = factory(Customer::class)->create([
            'user_id' => $this->user->id->string
        ]);

        // add product to cart
        $response = $this->json('GET', '/api/addToCart/'.$product->id->string);

        //check if the product is successfully added 
        $response->assertStatus(201);

        $data = [
            'user_id' => $this->user->id->string,
            'customer_id' => $customer->id->string,
            'qty' =>  1,
            'subtotal' => $product->buying_price ,
            'total' => $product->buying_price ,
            'pay' =>  $product->buying_price,
            'payby' =>  "Cheaque",
            'total_discount' =>  0
        ];

        $response = $this->json('Post', '/api/orderdone', $data);

        $response->assertStatus(200);
    }

}
