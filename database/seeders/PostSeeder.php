<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user     = User::first();
        $category = Category::firstOrCreate(
            ['name' => 'Technology']
        );

        $data = [
            [
                'user_id'     => $user->uuid,
                'category_id' => $category->uuid,
                'title'       => 'The Future of Artificial Intelligence',
                'status'      => 'publish',
                'content'     => '<p>Artificial Intelligence is revolutionizing the way we interact with technology. From self-driving cars to personalized assistants, AI is becoming a core part of our daily lives.</p>',
            ],
            [
                'user_id'     => $user->uuid,
                'category_id' => $category->uuid,
                'title'       => 'Why Cybersecurity Matters More Than Ever',
                'status'      => 'publish',
                'content'     => '<p>With the rise of digital threats, strong cybersecurity practices are essential to protect data, maintain privacy, and ensure business continuity in the digital world.</p>',
            ],
            [
                'user_id'     => $user->uuid,
                'category_id' => $category->uuid,
                'title'       => '5G Technology and Its Impact on Society',
                'status'      => 'publish',
                'content'     => '<p>5G brings faster speeds and more reliable connections, transforming industries such as healthcare, gaming, and transportation.</p>',
            ],
            [
                'user_id'     => $user->uuid,
                'category_id' => $category->uuid,
                'title'       => 'How Cloud Computing is Changing Business',
                'status'      => 'publish',
                'content'     => '<p>Cloud services allow companies to scale quickly, reduce costs, and improve collaboration. Learn why cloud adoption is booming across all sectors.</p>',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Post::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
