<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UserModelTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function user_has_ful_name()
    {
        $user = User::create([
            'name' => 'abdelhak',
            'email' =>'abdelhak123@gmail.com',
            'password' => 'secret',
            'latitude' => rand(35*10000,36*10000)/10000,
            'longitude' => -1*(rand(0,1*10000)/10000)
        ]);
        $this->assertEquals('abdelhak',$user->full_name());
    }
}
