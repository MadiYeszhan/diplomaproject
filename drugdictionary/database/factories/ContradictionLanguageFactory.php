<?php

namespace Database\Factories;

use App\Models\Contradiction;
use App\Models\ContradictionLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContradictionLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContradictionLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contradiction_id' => Contradiction::pluck('id')->random(),
            'language' => rand(1,3),
            'description' => $this->faker->sentence(5)
        ];
    }
}
