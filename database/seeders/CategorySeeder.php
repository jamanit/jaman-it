<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Web Development'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Tech News'],
        ];

        foreach ($data as $item) {
            \App\Models\Category::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
