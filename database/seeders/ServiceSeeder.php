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
            ],
            [
                'title'       => 'Chat AI',
                'description' => 'Layanan percakapan cerdas berbasis AI untuk menjawab pertanyaan Anda secara instan.',
                'content'     => '<p>Gunakan Chat AI untuk mendapatkan jawaban cepat dan akurat dari berbagai topik, termasuk teknologi, pendidikan, dan banyak lagi.</p>',
            ],
            [
                'title'       => 'Word to PDF',
                'description' => 'Konversi dokumen Word (.docx) ke format PDF dengan mudah dan cepat.',
                'content'     => '<p>Cukup unggah file Word Anda dan dapatkan file PDF berkualitas tinggi dalam hitungan detik. Tidak diperlukan instalasi software.</p>',
            ],
            [
                'title'       => 'JPG to PDF',
                'description' => 'Gabungkan gambar JPG menjadi satu dokumen PDF.',
                'content'     => '<p>Unggah satu atau beberapa gambar JPG, atur urutannya, lalu unduh hasilnya dalam format PDF yang rapi.</p>',
            ],
            [
                'title'       => 'Image Compressor',
                'description' => 'Kompres ukuran gambar tanpa mengurangi kualitas secara signifikan.',
                'content'     => '<p>Kurangi ukuran file gambar untuk mempercepat loading website atau menghemat ruang penyimpanan. Mendukung format JPG, PNG, dan lainnya.</p>',
            ],
        ];

        foreach ($services as $item) {
            Service::create([
                'category_id' => $category->uuid,
                'title'       => $item['title'],
                'slug'        => Str::slug($item['title']),
                'thumbnail'   => null,
                'description' => $item['description'],
                'content'     => $item['content'],
                'view_total'  => 0,
                'is_active'   => true,
            ]);
        }
    }
}
