<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_name = $this->faker->words($nb=4,$asText=true);
        $slug= Str::slug($product_name);
        return [
            'name'=>$product_name,
            'slug'=>$slug,
            'shortDescription'=>$this->faker->text(200),
            'description'=>$this->faker->text(200),
            'regularPrice'=>$this->faker->numberBetween(10,500),
            'SKU'=>'DIGI'.$this->faker->numberBetween(10,500),
            'stockStatus'=>'instock',
            'quantity'=>$this->faker->numberBetween(100,200),
            'image'=>'digital_'.$this->faker->numberBetween(1,22).'.jpg',
            'categoryId'=>$this->faker->numberBetween(1,5)
        ];
    }
}
