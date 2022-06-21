<?php

namespace Database\Factories;

use App\Models\ToursTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToursTypesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToursTypes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_de' => $this->faker->word,
        'name_en' => $this->faker->word,
        'name_ru' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
