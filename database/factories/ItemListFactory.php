<?php

namespace Database\Factories;

use App\Models\ItemList;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemList>
 */
class ItemListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1,20),
            'item_id' => Item::all()->random()->id,
        ];
    }
}
