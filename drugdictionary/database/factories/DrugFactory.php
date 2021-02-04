<?php

namespace Database\Factories;

use App\Models\Disease;
use App\Models\Drug;
use App\Models\DrugCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Drug::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drug_category_id' => DrugCategory::pluck('id')->random(),
            'disease_id' => Disease::pluck('id')->random(),
            'child_contradiction' => rand(0,1),
            'pregnancy_contradiction' => rand(0,1)
        ];
    }
}
