<?php

namespace Database\Factories;

use App\Models\ToursConditions;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToursConditionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToursConditions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_en' => $this->faker->word,
        'description_en' => $this->faker->text,
        'name_de' => $this->faker->word,
        'description_de' => $this->faker->text,
        'name_ru' => $this->faker->word,
        'description_ru' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
