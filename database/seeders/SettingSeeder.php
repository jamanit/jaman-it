<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SettingItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'siteConfig' => Setting::updateOrCreate(['name' => 'Site Config']),
            'contact'    => Setting::updateOrCreate(['name' => 'Contact']),
        ];

        $settingItems = [
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'Site Name',
                'key'             => 'site_name',
                'type'            => 'text',
                'value'           => 'Jaman IT',
            ],
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'Website URL',
                'key'             => 'website_url',
                'type'            => 'url',
                'value'           => 'http://127.0.0.1:8000/',
            ],
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'Logo',
                'key'             => 'logo',
                'type'            => 'file',
                'value_file'      => null,
            ],
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'Favicon',
                'key'             => 'favicon',
                'type'            => 'file',
                'value_file'      => null,
            ],
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'Meta',
                'key'             => 'meta',
                'type'            => 'textarea',
                'value'           => '<meta name="description" content="Discover various smart and handy services, all free and instantly accessible." />
    <meta name="keywords" content="jaman it, services online" />
    <meta name="author" content="Jaman IT Team" />
    <meta property="og:title" content="Jaman IT - Explore Our Free Online Services" />
    <meta property="og:description" content="Discover various smart and handy services, all free and instantly accessible." />
    <meta property="og:image" content="images/favicon.png" />
    <meta property="og:url" content="https://github.com/jamanit" />
    <meta property="og:type" content="website" />',
            ],
            [
                'setting_id' => $settings['siteConfig']->uuid,
                'name'            => 'About',
                'key'             => 'about',
                'type'            => 'textarea_editor',
                'value'           => '<p>Jaman IT menyediakan berbagai layanan online gratis yang memudahkan hidup Anda. Mulai dari kompresi gambar, konversi dokumen, hingga layanan berbasis AI — semua tersedia secara instan dan tanpa biaya. Kami percaya bahwa teknologi harus dapat diakses oleh siapa saja, kapan saja.</p>',
            ],
            [
                'setting_id' => $settings['contact']->uuid,
                'name'            => 'Address',
                'key'             => 'address',
                'type'            => 'text',
                'value'           => 'Simp. Rimbo Kota Jambi, Indonesia 36129',
            ],
            [
                'setting_id' => $settings['contact']->uuid,
                'name'            => 'Email',
                'key'             => 'email',
                'type'            => 'email',
                'value'           => 'itservice.jaman@gmail.com',
            ],
            [
                'setting_id' => $settings['contact']->uuid,
                'name'            => 'Phone Number',
                'key'             => 'phone_number',
                'type'            => 'number',
                'value'           => '+6289508475453',
            ],
            [
                'setting_id' => $settings['contact']->uuid,
                'name'            => 'Working Hours',
                'key'             => 'working_hours',
                'type'            => 'textarea_editor',
                'value'           => '<p>Monday - Friday: 9:00 AM to 6:00 PM</p> <p>Saturday - Sunday: Closed</p>',
            ],
        ];
        foreach ($settingItems as $settingItem) {
            SettingItem::updateOrCreate(['name' => $settingItem['name']], $settingItem);
        }
    }
}
