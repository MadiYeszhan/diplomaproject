<?php

namespace Database\Factories;

use App\Models\Drug;
use App\Models\SideEffect;
use Illuminate\Database\Eloquent\Factories\Factory;

class SideEffectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SideEffect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drug_id' => Drug::pluck('id')->random()
        ];
    }
}
