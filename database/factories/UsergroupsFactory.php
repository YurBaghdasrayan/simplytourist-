<?php

namespace Database\Factories;

use App\Models\Usergroups;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsergroupsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usergroups::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'usergroup_name' => $this->faker->word,
        'usergroup_description' => $this->faker->text,
        'usergroup_privat' => $this->faker->word,
        'language_iso' => $this->faker->word,
        'country_iso' => $this->faker->word,
        'member_count' => $this->faker->randomDigitNotNull,
        'edit_lock' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
