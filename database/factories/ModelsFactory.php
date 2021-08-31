<?php

$factory->define(App\User::class, function(Faker\Generator $faker){
    return[
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(Str::random(10)),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Models\Product::class, function(Faker\Generator $faker){
    return[
            'user_id' => factory(App\Models\User::class)->create()->id,
            'category_id' =>factory(App\Models\Category::class)->create()->id,
            'supplier_id' => factory(App\Models\Supplier::class)->create()->id,
            'product_name' => $this->faker->sentence(),
            'product_code' => $this->faker->unique()->randomDigit(),
            'buying_price' => $this->faker->numberBetween($min = 1000, $max = 6000),
            'selling_price' => $this->faker->numberBetween($min = 0, $max = 1000),
            'buying_date' => $this->faker->dateTimeBetween('-1 week', '+1 month'),
            'product_quantity' => $this->faker->numberBetween($min = 10, $max = 50),
            'min_quantity' => $this->faker->numberBetween($min = 1, $max = 5)
    ];
});