<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_en' => $this->faker->word,
        'name_de' => $this->faker->word,
        'name_ru' => $this->faker->word,
        'equipment_type_id' => $this->faker->randomDigitNotNull,
        'packlist_hiking_daytour' => $this->faker->word,
        'packlist_skitour' => $this->faker->word,
        'packlist_via_ferrata' => $this->faker->word,
        'packlist_ice_climbing' => $this->faker->word,
        'packlist_bouldering_on_rock' => $this->faker->word,
        'packlist_expedition' => $this->faker->word,
        'packlist_indoor_climbing' => $this->faker->word,
        'packlist_snowshoe_tour' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
