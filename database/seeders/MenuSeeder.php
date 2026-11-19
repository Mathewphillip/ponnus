<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the menus table with the five sample menu items.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Chicken Pilau',
                'description' => 'Fragrant spiced basmati rice cooked with tender pieces of marinated chicken, fried onions, and authentic East African spices.',
                'category' => 'Main Course',
                'price' => 15000,
                'availability' => 'Available',
            ],
            [
                'name' => 'Beef Burger',
                'description' => 'Juicy flame-grilled beef patty served in a toasted brioche bun with cheddar cheese, fresh lettuce, tomatoes, and chef specialty sauce.',
                'category' => 'Fast Food',
                'price' => 18000,
                'availability' => 'Available',
            ],
            [
                'name' => 'Vegetable Pizza',
                'description' => 'Crispy thin-crust artisan pizza topped with rich tomato sauce, mozzarella, bell peppers, black olives, onions, and mushrooms.',
                'category' => 'Pizza',
                'price' => 25000,
                'availability' => 'Available',
            ],
            [
                'name' => 'Fresh Juice',
                'description' => 'Freshly extracted chilled seasonal passion fruit and orange juice with mint, 100% natural with no artificial preservatives.',
                'category' => 'Beverages',
                'price' => 5000,
                'availability' => 'Available',
            ],
            [
                'name' => 'Grilled Chicken',
                'description' => 'Half chicken slow-marinated in garlic, lemon, and fine herbs, char-grilled to juicy tenderness and served with seasoned potato wedges.',
                'category' => 'Main Course',
                'price' => 28000,
                'availability' => 'Unavailable',
            ],
        ];

        foreach ($items as $item) {
            Menu::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
