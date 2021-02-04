<?php

namespace Database\Factories;

use App\Models\SideEffect;
use App\Models\SideEffectLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SideEffectLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SideEffectLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'side_effect_id' => SideEffect::pluck('id')->random(),
            'language' => rand(1,3),
            'description' => $this->faker->sentence(5),
            'general' => $this->faker->sentence(5),
            'doctor_attention' => $this->faker->sentence(5)

        ];
    }
}
