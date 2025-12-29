<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\SettingBanner;
use App\Models\SettingWebsite;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'humas']);

        User::create([
            'name' => 'Fajri - Developer',
            'email' => 'fajri@gariskode.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');

        SettingWebsite::create([
            'name' => 'Organisasi Berbasis IT (ORBIT)',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'email' => 'halo@ukmorbituinbkt.com',
            'phone' => '+62 8XX-XXXX-XXXX',
            'address' => 'Gedung XXXX, UIN Sjech M. Djamil Djambek Bukittinggi,',
            'latitude' => '-0.32177371869479526',
            'longitude' => '100.39795359131934',
            'about' => '<p><strong>Organisasi Berbasis IT (ORBIT)</strong> adalah sebuah organisasi yang bergerak di bidang teknologi informasi dan komunikasi di lingkungan UIN Sjech M. Djamil Djambek Bukittinggi. ORBIT bertujuan untuk mengembangkan potensi mahasiswa dalam bidang IT serta memberikan kontribusi positif bagi masyarakat melalui inovasi teknologi.</p>',
        ]);

        SettingBanner::create([
            'title' => 'Organisasi Berbasis IT (ORBIT)',
            'subtitle' => 'Organisasi yang bergerak di bidang teknologi informasi dan komunikasi di lingkungan UIN Sjech M. Djamil Djambek Bukittinggi',
            'image' => 'setting/banner/vC5qyP6SqARhMTDtFaUm.png',
            'url' => 'https://uinbukittinggi.ac.id',
        ]);
        NewsCategory::create([
            'name' => 'Berita',
            'slug' => 'berita',
            'description' => 'Kategori berita adalah kategori yang berisi informasi terkini dan terbaru mengenai kegiatan, acara, dan informasi penting lainnya yang terjadi di lingkungan Universitas Islam Negeri Sjech M. Djamil Djambek Bukittinggi.',
        ]);

        News::create([
            'title' => 'ORBIT Gelar Workshop Teknologi untuk Mahasiswa UIN Bukittinggi',
            'slug' => 'orbit-gelar-workshop-teknologi-untuk-mahasiswa-uin-bukittinggi',
            'news_category_id' => 1,
            'thumbnail' => null,
            'content' => '<p class="ql-align-justify">Bukittinggi (ORBIT) – Organisasi Berbasis IT (ORBIT) UIN Sjech M. Djamil Djambek Bukittinggi sukses menggelar workshop teknologi bertajuk “Inovasi Digital untuk Mahasiswa” pada 5 Maret 2025. Acara ini diikuti puluhan mahasiswa dari berbagai jurusan yang antusias memperdalam pengetahuan di bidang teknologi informasi.</p><p class="ql-align-justify">Workshop menghadirkan pemateri dari praktisi IT dan dosen UIN Bukittinggi yang membahas tren teknologi terbaru, pengembangan aplikasi, serta peluang karir di dunia digital. Ketua ORBIT, Ahmad Fauzi, menyampaikan bahwa kegiatan ini bertujuan meningkatkan literasi digital mahasiswa dan mendorong inovasi di lingkungan kampus.</p><p class="ql-align-justify">“Kami berharap workshop ini dapat menjadi wadah bagi mahasiswa untuk mengembangkan potensi dan kreativitas di bidang teknologi,” ujar Ahmad. Peserta juga mendapatkan sertifikat dan akses materi eksklusif sebagai bentuk apresiasi atas partisipasi mereka.</p><p><br></p>',
            'user_id' => 1,
            'status' => 'published',
            'meta_title' => 'ORBIT Gelar Workshop Teknologi untuk Mahasiswa UIN Bukittinggi',
            'meta_description' => 'ORBIT UIN Bukittinggi mengadakan workshop teknologi untuk meningkatkan literasi digital dan inovasi mahasiswa.',
            'meta_keywords' => 'orbit; workshop; teknologi; mahasiswa; uin bukittinggi',
        ]);
    }
}
