<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'name'     => 'Abid Dakhilullah',
            'email'    => 'abid@flipplay.test',
            'password' => 'password123',
        ]);

        $user2 = User::create([
            'name'     => 'Raka Pratama',
            'email'    => 'raka@flipplay.test',
            'password' => 'password123',
        ]);

        $media1 = Media::create([
            'judul'               => 'Inception',
            'jenis'               => 'video',
            'genre'               => 'Sci-Fi',
            'pembuat'             => 'Christopher Nolan',
            'tahun_rilis'         => 2010,
            'durasi_atau_halaman' => 148,
            'deskripsi'           => 'Film fiksi ilmiah tentang pencurian ide melalui alam bawah sadar.',
        ]);

        $media2 = Media::create([
            'judul'               => 'Clean Code',
            'jenis'               => 'digital_reading',
            'genre'               => 'Teknologi',
            'pembuat'             => 'Robert C. Martin',
            'tahun_rilis'         => 2008,
            'durasi_atau_halaman' => 464,
            'deskripsi'           => 'Panduan menulis kode perangkat lunak yang bersih dan mudah dirawat.',
        ]);

        $user1->media()->attach([$media1->id, $media2->id]);
        $user2->media()->attach([$media1->id]);
    }
}
