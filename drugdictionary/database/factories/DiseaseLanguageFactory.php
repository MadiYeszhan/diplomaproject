<?php

namespace Database\Factories;

use App\Models\Disease;
use App\Models\DiseaseLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiseaseLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiseaseLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'disease_id' => Disease::pluck('id')->random(),
            'language' => rand(1,3),
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5)
        ];
    }
}
