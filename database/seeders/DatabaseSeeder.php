<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Insert Kategori Event
        $category = \App\Models\Category::firstOrCreate([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);
        $category2 = \App\Models\Category::firstOrCreate([
            'name' => 'Entertaiment',
            'slug' => 'entertaiment',
        ]);
        $category3 = \App\Models\Category::firstOrCreate([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);
        $category4 = \App\Models\Category::firstOrCreate([
            'name' => 'Kompetisi',
            'slug' => 'kompetisi',
        ]);
        $category5 = \App\Models\Category::firstOrCreate([
            'name' => 'Festival',
            'slug' => 'festival',
        ]);

        // 3. Insert Sampel Events
        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',

            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'Hackaton - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Workshop UI/UX Design dengan Figma',
            'description' => 'Belajar membuat desain aplikasi dari nol hingga prototype.',
            'date' => '2026-06-01 09:00:00',
            'location' => 'Lab Komputer 1',
            'price' => 75000,
            'stock' => 30,
            'poster_path' => 'posters/event-4.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Workshop Laravel CRUD dari Nol',
            'description' => 'Belajar membuat aplikasi CRUD menggunakan Laravel dari dasar hingga database.',
            'date' => '2026-06-01 13:00:00',
            'location' => 'Lab Komputer 1',
            'price' => 75000,
            'stock' => 30,
            'poster_path' => 'posters/event-5.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category4->id,
            'title' => 'Hackathon 24 Jam Amikom',
            'description' => 'Kompetisi coding intensif selama 24 jam untuk membangun solusi digital inovatif dalam tim.',
            'date' => '2026-06-10 07:30:00',
            'location' => 'Inkubator Amikom',
            'price' => 100000,
            'stock' => 50,
            'poster_path' => 'posters/event-6.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category4->id,
            'title' => 'Web Development Competition 2026',
            'description' => 'Lomba pembuatan website kreatif dan fungsional dengan penilaian UI/UX dan performa.',
            'date' => '2026-06-17 09:00:00',
            'location' => 'Lab Programming 2',
            'price' => 75000,
            'stock' => 40,
            'poster_path' => 'posters/event-7.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category5->id,
            'title' => 'Amikom Music Festival 2026',
            'description' => 'Festival musik kampus dengan penampilan band mahasiswa, guest star, dan berbagai hiburan menarik.',
            'date' => '2026-06-17 18:00:00',
            'location' => 'Lapangan Utama Amikom',
            'price' => 150000,
            'stock' => 500,
            'poster_path' => 'posters/festival-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category5->id,
            'title' => 'Creative Tech Festival 2026',
            'description' => 'Festival teknologi dan kreativitas yang menampilkan game expo, showcase project, dan live performance.',
            'date' => '2026-06-19 09:00:00',
            'location' => 'Lapangan Utama Amikom',
            'price' => 100000,
            'stock' => 300,
            'poster_path' => 'posters/festival-2.png',
        ]);
    }
}
