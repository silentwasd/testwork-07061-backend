<?php

namespace Database\Seeders;

use App\Models\BoardItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BoardItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => 'iPhone 8',
                'content' => 'Продаю в отличном состоянии, ни разу не падал, в воде не купался.',
                'item_type' => 'sell',
                'price_value' => '20000',
                'published_at' => Carbon::create(2022, 6, 21, 12)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => 'Hyundai Grandeur (2013 года)',
                'content' => 'Обслуживается у официального дилера сервисная книга с отметками имеется. Пробег 100% оригинальный.',
                'item_type' => 'sell',
                'price_value' => '1295000',
                'published_at' => Carbon::create(2022, 6, 5, 9, 53, 22)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => '1-к. квартира, 32 м², 3/5 эт.',
                'content' => 'Сдается однокомнатная квартира с отличным ремонтом в своем сегменте!',
                'item_type' => 'rent',
                'price_type' => 'monthly',
                'price_value' => '15000',
                'published_at' => Carbon::create(2022)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => 'Ремонт смартфонов Android и iPhone',
                'content' => 'Высококачественный ремонт мобильной техники по низким ценам.',
                'item_type' => 'service',
                'price_range' => 'from',
                'price_value' => '1000',
                'published_at' => Carbon::create(2022, 6, 21, 15, 15, 21)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => 'Медь',
                'content' => 'Куплю медь дорого.',
                'item_type' => 'buy',
                'price_type' => 'weight',
                'price_value' => '450',
                'published_at' => Carbon::create(2022, 5, 25, 9)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => '2-к. квартира, от 50 м²',
                'content' => 'Ищу квартиру в аренду от 50 м², двухкомнатную со стиральной машиной.',
                'item_type' => 'want-rent',
                'price_range' => 'to',
                'price_value' => '60000',
                'published_at' => Carbon::create(2022, 6, 19, 15, 30, 1)
            ]),
            new BoardItem([
                'user_id' => User::factory()->count(1)->create()->first()->id,
                'title' => 'Доставка товара из Беларуси',
                'content' => 'Заказал товар в Минске, и нужно доставить его в Москву.',
                'item_type' => 'want-service',
                'price_value' => '10000',
                'published_at' => Carbon::create(2022, 6, 21, 18)
            ])
        ];

        foreach ($items as $item)
            $item->save();
    }
}
