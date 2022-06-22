<?php

namespace Database\Factories;

use App\Models\BoardItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BoardItemFactory extends Factory
{
    protected $model = BoardItem::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->count(1)->create()->first()->id,
            'title' => $this->faker->sentence,
            'content' => $this->faker->text,
            'item_type' => $this->faker->randomElement(['sell', 'buy', 'want-service', 'service', 'want-rent', 'rent']),
            'price_type' => $this->faker->randomElement(['simple', 'weight', 'monthly']),
            'price_range' => $this->faker->randomElement(['from', 'to', 'exact']),
            'price_value' => rand(1000, 100000),
            'published_at' => $this->faker->dateTimeBetween('-2 years'),
            'removed_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
