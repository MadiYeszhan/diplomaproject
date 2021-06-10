<?php

namespace Database\Factories;

use App\Models\Drug;
use App\Models\DrugTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrugTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drug_id' => Drug::pluck('id')->random(),
            'language' => rand(1,3),
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'weight' => rand(1,254),
        ];
    }
}
