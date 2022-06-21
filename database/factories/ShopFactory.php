<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_ru' => $this->faker->word,
        'name_en' => $this->faker->word,
        'name_de' => $this->faker->randomDigitNotNull,
        'equipment_id' => $this->faker->randomDigitNotNull,
        'equipment_type_id' => $this->faker->randomDigitNotNull,
        'shop_url_ru' => $this->faker->randomDigitNotNull,
        'shop_url_en' => $this->faker->randomDigitNotNull,
        'shop_url_de' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'is_default' => $this->faker->word
        ];
    }
}
