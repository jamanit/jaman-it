<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['name' => 'Tool']
        );

        $services = [
            [
                'title'       => 'Image to PDF',
                'description' => 'Ubah gambar menjadi dokumen PDF dengan cepat dan mudah.',
                'content'     => '<p>Unggah satu atau beberapa gambar dan konversikan menjadi satu file PDF. Mendukung format JPG, PNG, BMP, dan lainnya.</p>',
                'is_popular'  => true,
            ],
            [
                'title'       => 'TikTok Saver',
                'description' => 'Unduh video TikTok tanpa watermark secara cepat dan gratis.',
                'content'     => '<p>Tempelkan tautan video TikTok, lalu unduh videonya dalam kualitas terbaik tanpa watermark. Proses cepat dan tanpa aplikasi tambahan.</p>',
                'is_popular'  => true,
            ],
            [
                'title'       => 'Chat AI',
                'description' => 'Layanan percakapan cerdas berbasis AI untuk menjawab pertanyaan Anda secara instan.',
                'content'     => '<p>Gunakan Chat AI untuk mendapatkan jawaban cepat dan akurat dari berbagai topik, termasuk teknologi, pendidikan, dan banyak lagi.</p>',
                'is_popular'  => true,
            ],
            [
                'title'       => 'Word to PDF',
                'description' => 'Konversi dokumen Word (.docx) ke format PDF dengan mudah dan cepat.',
                'content'     => '<p>Cukup unggah file Word Anda dan dapatkan file PDF berkualitas tinggi dalam hitungan detik. Tidak diperlukan instalasi software.</p>',
                'is_popular'  => true,
            ],
            [
                'title'       => 'Image Compressor',
                'description' => 'Kompres ukuran gambar tanpa mengurangi kualitas secara signifikan.',
                'content'     => '<p>Kurangi ukuran file gambar untuk mempercepat loading website atau menghemat ruang penyimpanan. Mendukung format JPG, PNG, dan lainnya.</p>',
                'is_popular'  => false,
            ],
        ];

        foreach ($services as $index => $item) {
            Service::create([
                'category_id' => $category->uuid,
                'title'       => $item['title'],
                'slug'        => Str::slug($item['title']),
                'thumbnail'   => null,
                'description' => $item['description'],
                'content'     => $item['content'],
                'view_total'  => 0,
                'order'       => $index + 1,
                'is_popular'  => $item['is_popular'],
                'is_active'   => true,
            ]);
        }
    }
}
