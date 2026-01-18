<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\MemberField;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Period;
use App\Models\PeriodUser;
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
        MemberField::create([
            'name' => 'Infokom',
            'slug' => 'infokom',
            'description' => 'Bidang Komunikasi yang mengelola informasi dan komunikasi organisasi.',
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
        Period::create([
            'name' => 'Periode 2022',
            'slug' => 'periode-2022',
            'start_date' => '2022-01-01',
            'end_date' => '2022-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2022.',
        ]);
        Period::create([
            'name' => 'Periode 2021',
            'slug' => 'periode-2021',
            'start_date' => '2021-01-01',
            'end_date' => '2021-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2021.',
        ]);
        Period::create([
            'name' => 'Periode 2020',
            'slug' => 'periode-2020',
            'start_date' => '2020-01-01',
            'end_date' => '2020-12-31',
            'description' => 'Periode kepengurusan ORBIT UIN Bukittinggi tahun 2020.',
        ]);

        PeriodUser::create([
            'period_id' => 1,
            'user_id' => 1,
            'role' => 'Kepala Bidang',
            'member_field_id' => 4,
        ]);

        User::create([
            'name' => 'Thoriq Aziz El Gifran',
            'email' => 'thoriq@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 2,
            'role' => 'Ketua Umum',
        ]);

        User::create([
            'name' => 'LAILA FATIYAH',
            'email' => 'lailafatiyah@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 3,
            'role' => 'Sekretaris Umum',
        ]);

        User::create([
            'name' => 'ADRYAN NAZWAN PERTAMA',
            'email' => 'adryannazwan@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 4,
            'role' => 'Bendahara Umum',
        ]);

        User::create([
            'name' => 'Fauzi',
            'email' => 'fauzi@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 5,
            'role' => 'Kepala Bidang',
            'member_field_id' => 4,
        ]);

        User::create([
            'name' => 'MUHAMMAD SYRAFI HIDAYATULLAH',
            'email' => 'muhammadsyrafi@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 6,
            'role' => 'Kepala Bidang',
            'member_field_id' => 1,
        ]);

        User::create([
            'name' => 'HAFIZ DZAKY',
            'email' => 'hafizdzaky@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 7,
            'role' => 'Kepala Bidang',
            'member_field_id' => 3,
        ]);

        User::create([
            'name' => 'NASYWA ASYURA',
            'email' => 'nasywaasyura@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 8,
            'role' => 'Kepala Bidang',
            'member_field_id' => 2,
        ]);

        User::create([
            'name' => 'RIDHO FAJRI',
            'email' => 'ridhofajri@ukmorbituinbkt.com',
            'password' => bcrypt('password'),
        ]);

        PeriodUser::create([
            'period_id' => 4,
            'user_id' => 9,
            'role' => 'Kepala Bidang',
            'member_field_id' => 5,
        ]);



    }
}
