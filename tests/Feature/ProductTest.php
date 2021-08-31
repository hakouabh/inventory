<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class ProductTest extends TestCase
{

    protected $product;

    public function setUp() :void {

        parent::setUp();

        $this->product = factory(Product::class)->create();

        $this->signIn();

    }
    /**test*/
    public function a_user_can_create_a_product(){

        $this->assertDatabaseHas('products',[
            'user_id' => $this->user->id
        ]);

    }
}
