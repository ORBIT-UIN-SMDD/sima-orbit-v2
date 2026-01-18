<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\MemberField;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Period;
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
            'image' => 'https://placehold.co/1920x1080/png',
            'url' => 'https://uinbukittinggi.ac.id',
        ]);
        NewsCategory::create([
            'name' => 'Berita',
            'slug' => 'berita',
            'description' => 'Kategori berita adalah kategori yang berisi informasi terkini dan terbaru mengenai kegiatan, acara, dan informasi penting lainnya yang terjadi di lingkungan Universitas Islam Negeri Sjech M. Djamil Djambek Bukittinggi.',
        ]);

        NewsCategory::create([
            'name' => 'ORBIT Peduli',
            'slug' => 'orbit-peduli',
            'description' => 'Kategori ORBIT Peduli adalah kategori yang berfokus pada kegiatan sosial dan kemanusiaan yang dilakukan oleh Organisasi Berbasis IT (ORBIT) di lingkungan UIN Sjech M. Djamil Djambek Bukittinggi, seperti bakti sosial, donasi, dan program-program lainnya yang bertujuan untuk memberikan dampak positif bagi masyarakat sekitar.',
        ]);

        NewsCategory::create([
            'name' => 'Kegiatan',
            'slug' => 'kegiatan',
            'description' => 'Kategori Kegiatan adalah kategori yang mencakup berbagai aktivitas, acara, dan program yang diselenggarakan oleh mahasiswa di lingkungan UIN Sjech M. Djamil Djambek Bukittinggi, termasuk organisasi kemahasiswaan, seminar, workshop, dan kegiatan ekstrakurikuler lainnya.',
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

        foreach (range(2, 8) as $i) {
            // Tambahkan data dummy menggunakan Faker
            $faker = \Faker\Factory::create('id_ID');
            News::create([
                'title' => $faker->sentence(6),
                'slug' => $faker->slug,
                'news_category_id' => rand(1, 3),
                'thumbnail' => null,
                'content' => '<p class="ql-align-justify">' . $faker->paragraph(5) . '</p>',
                'user_id' => 1,
                'status' => 'published',
                'meta_title' => $faker->sentence(6),
                'meta_description' => $faker->sentence(10),
                'meta_keywords' => implode(', ', $faker->words(5)),
            ]);
        }

        AboutUs::create([
            'name' => 'Tentang ORBIT UIN Bukittinggi',
            'content' => '<p><strong>Organisasi Berbasis IT (ORBIT)</strong> adalah sebuah organisasi yang bergerak di bidang teknologi informasi dan komunikasi di lingkungan UIN Sjech M. Djamil Djambek Bukittinggi. ORBIT bertujuan untuk mengembangkan potensi mahasiswa dalam bidang IT serta memberikan kontribusi positif bagi masyarakat melalui inovasi teknologi.</p><p>Sejak didirikan pada tahun 2020, ORBIT telah melaksanakan berbagai kegiatan seperti workshop, seminar, dan pelatihan yang berkaitan dengan teknologi informasi. Organisasi ini juga aktif dalam mengembangkan aplikasi dan solusi digital yang bermanfaat bagi civitas akademika UIN Bukittinggi.</p><p>Dengan semangat kolaborasi dan inovasi, ORBIT terus berupaya menjadi pionir dalam pengembangan teknologi di lingkungan kampus serta memberikan dampak positif bagi masyarakat luas.</p>',
        ]);

        MemberField::create([
            'name' => 'Programming',
            'slug' => 'programming',
            'description' => 'Bidang yang fokus pada pengembangan perangkat lunak dan aplikasi.',
        ]);
        MemberField::create([
            'name' => 'Multimedia',
            'slug' => 'multimedia',
            'description' => 'Bidang yang berkaitan dengan desain grafis, video editing, dan produksi konten digital.',
        ]);
        MemberField::create([
            'name' => 'Networking',
            'slug' => 'networking',
            'description' => 'Bidang yang menangani infrastruktur jaringan dan komunikasi data.',
        ]);
        MemberField::create([
            'name' => 'Robotics',
            'slug' => 'robotics',
            'description' => 'Bidang yang mempelajari dan mengembangkan teknologi robotika.',
        ]);

        Period::create([
            'name' => 'Periode 2023',
            'slug' => 'periode-2023',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2023.',
        ]);

        Period::create([
            'name' => 'Periode 2024',
            'slug' => 'periode-2024',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2024.',
        ]);

        Period::create([
            'name' => 'Periode 2025',
            'slug' => 'periode-2025',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2025.',
        ]);

        Period::create([
            'name' => 'Periode 2026',
            'slug' => 'periode-2026',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2026.',
        ]);

    }
}
