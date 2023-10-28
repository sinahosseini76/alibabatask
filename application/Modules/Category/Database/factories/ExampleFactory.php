<?php

namespace Modules\Example\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExampleFactory extends Factory
{
//    protected $model = Product::class;

    public function definition()
    {
        return [
            'item' => "Value",
        ];
    }
}
