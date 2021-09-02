<?php

$factory->define(App\User::class, function(Faker\Generator $faker){
    return[
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(Str::random(10)),
        'remember_token' => Str::random(10),
        'longitude' => rand(35*10000,36*10000)/10000,
        'latitude' => -1*(rand(0,1*10000)/10000)
    ];
});

$factory->define(App\Model\Category::class, function(Faker\Generator $faker){
    return[
            'user_id' => factory(App\User::class)->create()->id,
            'category_name' => $this->faker->sentence()
    ];
});

$factory->define(App\Model\Supplier::class, function(Faker\Generator $faker){
    return[
            'user_id' => factory(App\User::class)->create()->id,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->unique()->randomDigit(),
            'address' => $this->faker->sentence(),
            'shopname' => $this->faker->sentence()
    ];
});

$factory->define(App\Model\Product::class, function(Faker\Generator $faker){
    return[
            'user_id' => factory(App\User::class)->create()->id,
            'category_id' =>factory(App\Model\Category::class)->create()->id,
            'supplier_id' => factory(App\Model\Supplier::class)->create()->id,
            'product_name' => $this->faker->name,
            'product_code' => $this->faker->unique()->randomDigit(),
            'buying_price' => $this->faker->numberBetween($min = 1000, $max = 6000),
            'selling_price' => $this->faker->numberBetween($min = 0, $max = 1000),
            'buying_date' => $this->faker->dateTimeBetween('-1 week', '+1 month'),
            'product_quantity' => $this->faker->numberBetween($min = 5, $max = 10),
            'min_quantity' => $this->faker->numberBetween($min = 1, $max = 5)
    ];
});

$factory->define(App\Model\Customer::class, function(Faker\Generator $faker){

    return[
            'user_id' => function () {
                return factory(App\User::class)->create()->id;
            },
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->unique()->randomDigit(),
            'address' => $this->faker->sentence()    
    ];

});