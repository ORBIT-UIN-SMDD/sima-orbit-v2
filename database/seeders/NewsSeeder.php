<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            'created_at' => '2025-03-05 10:00:00',
            'updated_at' => '2025-03-05 10:00:00',
        ]);
    }
}
