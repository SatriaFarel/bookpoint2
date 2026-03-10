<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        /* ================= USERS ================= */

        User::create([
            'nik' => '1234567890123456',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'image' => null,
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_rekening' => '1234567890',
        ]);

        User::create([
            'nik' => '1234567890123457',
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'image' => null,
            'password' => Hash::make('password'),
            'role' => 'seller',
            'no_rekening' => '1234567890',
        ]);

        User::create([
            'nik' => '1234567890123458',
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'image' => null,
            'password' => Hash::make('password'),
            'role' => 'customer',
            'no_rekening' => null,
        ]);


        /* ================= CATEGORIES ================= */

        Category::create([
            'name' => 'Buku Motivasi'
        ]);

        Category::create([
            'name' => 'Buku Programming'
        ]);


        /* ================= PRODUCTS ================= */

        Product::create([
            'seller_id' => 1,
            'category_id' => 1,
            'name' => 'Atomic Habits',
            'price' => 120000,
            'stock' => 20,
            'image' => 'books/atomic-habits.jpg'
        ]);

        Product::create([
            'seller_id' => 1,
            'category_id' => 1,
            'name' => 'Deep Work',
            'price' => 110000,
            'stock' => 15,
            'image' => 'books/deep-work.jpg'
        ]);

        Product::create([
            'seller_id' => 1,
            'category_id' => 2,
            'name' => 'Clean Code',
            'price' => 180000,
            'stock' => 10,
            'image' => 'books/clean-code.jpg'
        ]);
    }
}