<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'MKN' => 'Makanan',
            'MNM' => 'Minuman'
        ];

        foreach ($categories as $code => $name) {
            Category::create([
                'code' => $code,
                'name' => $name
            ]);
        }
    }
}
