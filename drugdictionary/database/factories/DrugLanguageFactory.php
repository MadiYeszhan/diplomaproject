<?php

namespace Database\Factories;

use App\Models\Drug;
use App\Models\DrugLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrugLanguage::class;

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
            'composition' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(5),
            'dosage' => $this->faker->sentence(5),
            'availability' => $this->faker->sentence(5),
            'special_instructions' => $this->faker->sentence(5),
            'drug_interaction' => $this->faker->sentence(5),
        ];
    }
}
