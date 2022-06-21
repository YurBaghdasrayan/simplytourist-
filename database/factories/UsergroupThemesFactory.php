<?php

namespace Database\Factories;

use App\Models\UsergroupThemes;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsergroupThemesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsergroupThemes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'usergroup_id' => $this->faker->randomDigitNotNull,
        'theme' => $this->faker->word,
        'user_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'tour_id' => $this->faker->randomDigitNotNull
        ];
    }
}
