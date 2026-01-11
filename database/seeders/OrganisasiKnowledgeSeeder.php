<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisasiKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'question' => 'Apakah ada organisasi yang berfokus pada olahraga di Polibatam?',
                'answer' => 'Ada, yaitu Komite Olahraga Polibatam (KOP). KOP adalah organisasi kemahasiswaan yang menaungi berbagai cabang olahraga seperti futsal, basket, voli, badminton, dan lainnya.',
                'keywords' => 'organisasi, olahraga, polibatam',
                'source' => 'https://www.instagram.com/kop.polibatam/'
            ],
            [
                'question' => 'Organisasi apa saja yang ada di Polibatam?',
                'answer' => 'Terdapat 16 ormawa di Polibatam, yaitu Dewan Perwakilan Mahasiswa (DPM), Badan Eksekutif Mahasiswa (BEM), Himpunan Mahasiswa Manajemen Bisnis (HMMB), Himpunan Mahasiswa Teknik Informatika (HMTI), Himpunan Mahasiswa Teknik Elektro (HME), Himpunan Mahasiswa Teknik Mesin (HME), Ikatan Mahasiswa Muslim Politeknik Negeri Batam (IMMPB), Persekutuan Doa El-Shaddai (PD.El-Shaddai), Mahasiswa Pencinta Alam (Mapala), Batam Linux User Group (BLUG), Polibatam English Club (PEC), Lembaga Pers Mahasiswa (LPM) Paradigma, Komite Olahrga Polibatam (KOP), Kumpulan Anak Seni (KUAS), Entrepreneur Generation (ENERGI) Politeknik Negeri Batam, REKA Multimedia (REKAM)',
                'keywords' => 'organisasi, polibatam, hima, ukm, kemahasiswaan, kegiatan, ormawa',
                'source' => 'https://polibatam.ac.id/kemahasiswaan'
            ],
            [
                'question' => 'Bagaimana cara bergabung dengan organisasi di Polibatam?',
                'answer' => 'Untuk bergabung dengan organisasi di Polibatam, mahasiswa baru biasanya dapat mendaftar saat masa orientasi atau open recruitment yang diadakan setiap awal semester. Informasi pendaftaran biasanya diumumkan melalui media sosial masing-masing organisasi.',
                'keywords' => 'bergabung, daftar, organisasi, polibatam, recruitment, cara',
                'source' => 'https://polibatam.ac.id/kemahasiswaan'
            ],
            [
                'question' => 'Apa itu HIMA di Polibatam?',
                'answer' => 'HIMA (Himpunan Mahasiswa) adalah organisasi kemahasiswaan yang berbasis program studi. Setiap jurusan di Polibatam memiliki HIMA sendiri yang berfungsi sebagai wadah aspirasi mahasiswa dan penyelenggara kegiatan akademik maupun non-akademik.',
                'keywords' => 'hima, himpunan, mahasiswa, organisasi, jurusan, program studi',
                'source' => 'https://polibatam.ac.id/kemahasiswaan'
            ],
            [
                'question' => 'Apakah ada organisasi yang berfokus pada seni di Polibatam?',
                'answer' => 'Ada, yaitu UKM KUAS atau singkatan dari Kumpulan Anak Seni, disini kamu bisa mengasah seni yang kamu punya mulai dari menari, bermain alat musik, bernyanyi, melukis dan berbagai seni lain',
                'keywords' => 'ukm, seni, ormawa, organisasi, polibatam, menari, bernyanyi',
                'source' => 'https://www.instagram.com/fotografi.polibatam/'
            ],
            [
                'question' => 'Apa itu ormawa REKAM?',
                'answer' => 'REKAM sendiri merupakan singkatan dari REKA Multimedia yang mencerminkan keterkaitan erat dengan dunia film dan broadcasting. REKAM memberikan kesempatan bagi anggotanya untuk mengembangkan keterampilan teknis dan kreatif dalam produksi film, penyiaran, serta aspek multimedia lainnya. UKM REKAM menjadi ruang kolaborasi bagi mahasiswa yang ingin mengekplorasi dunia perfilman dan broadcasting secara lebih mendalam, baik dalam lingkup akademik maupun industry kreatif.',
                'keywords' => 'REKAM, ormawa, REKA, Multimedia, film, broadcasting',
                'source' => 'https://www.instagram.com/rekam.polibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'Apa itu ormawa kop?',
                'answer' => 'Komite Olahraga Politeknik Negeri Batam merupakan sebuah UKM yang bertujuan untuk mengembangkan olahraga di lingkungan kampus. UKM ini berfokus pada pengembangan minat dan bakat mahasiswa dalam bidang olahraga. Komite ini didirikan pada tanggal 11 Juli 2008.',
                'keywords' => 'ormawa, kop, olahraga, ukm, komite olahrga, politeknik',
                'source' => 'https://www.instagram.com/komiteolahragapolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa pd-elshaddai?',
                'answer' => 'PD.El-Shaddai atau Persekutuaan Doa ElShaddai tepatnya 20 Maret 2003, El-Shaddai hadir sebagai wadah 𝘱𝘦𝘮𝘣𝘪𝘯𝘢𝘢𝘯 𝘪𝘮𝘢𝘯 𝘮𝘢𝘩𝘢𝘴𝘪𝘴𝘸𝘢 𝘒𝘳𝘪𝘴𝘵𝘦𝘯 𝘗𝘰𝘭𝘪𝘣𝘢𝘵𝘢𝘮, 𝘒𝘰𝘮𝘶𝘯𝘪𝘵𝘢𝘴 𝘺𝘢𝘯𝘨 𝘮𝘦𝘯𝘶𝘮𝘣𝘶𝘩𝘬𝘢𝘯 𝘬𝘢𝘳𝘢𝘬𝘵𝘦𝘳 𝘬𝘳𝘪𝘴𝘵𝘪𝘢𝘯𝘪, 𝘛𝘦𝘮𝘱𝘢𝘵 𝘱𝘦𝘯𝘨𝘦𝘮𝘣𝘢𝘯𝘨𝘢𝘯 𝘵𝘢𝘭𝘦𝘯𝘵𝘢 𝘶𝘯𝘵𝘶𝘬 𝘬𝘦𝘮𝘶𝘭𝘪𝘢𝘢𝘯 𝘛𝘶𝘩𝘢𝘯.',
                'keywords' => 'ormawa, pd-elshaddai, persekutuan doa, politeknik',
                'source' => 'https://www.instagram.com/pd_elshaddai?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa pec?',
                'answer' => 'Polybatam English Club atau yang kerap disebut PEC hadir sebagai wadah pengembangan kemampuan berbahasa Inggris bagi mahasiswa Polibatam, UKM ini berdiri pada tanggal 12 Maret 2008.',
                'keywords' => 'pec, ormawa, ukm,Polybatam English Club, inggris, bahasa, politeknik.',
                'source' => 'https://www.instagram.com/polibatamenglishclub?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa kuas?',
                'answer' => 'KUMPULAN ANAK SENI POLITEKNIK NEGERI BATAM atau yang kerap disebut KUAS merupakan salah satu Unit Kegiatan Mahasiswa yang bergerak di bidang seni dan bernaung di bawah Politeknik Negeri Batam. KUAS didirikan pada tanggal 9 November 2009, lahir sebagai wadah pengembangan, peningkatan, dan penyaluran minat serta bakat mahasiswa, KUAS terus berkomitmen untuk menjadi ruang berkarya bagi insan seni Polibatam.',
                'keywords' => 'prmawa, kuas, ukm, seni, politeknik',
                'source' => 'https://www.instagram.com/kuaspolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa hme?',
                'answer' => 'Himpunan Mahasiswa Elektro (HME) merupakan sebuah organisasi Politeknik Negeri Batam yang didirikan pada tanggal 8 April 2002. Organisasi ini hadir sebagai wadah bagi mahasiswa jurusan elektro untuk berkembang dan berkontribusi.',
                'keywords' => 'ormawa, hme, elektro, organisasi, himpunan, politeknik',
                'source' => 'https://www.instagram.com/hmepolbat?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa hmm?',
                'answer' => 'Himpunan Mahasiswa Mesin (HMM) merupakan sebuah organisasi yang dibentuk pada tanggal 26 Maret 2012 dengan tujuan menjadi suatu organisasi yang dapat menaungi seluruh mahasiswa jurusan mesin.',
                'keywords' => 'ormawa, hmm, mesin, organisasi, himpunan, politeknik',
                'source' => 'https://www.instagram.com/hmmpolbat?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu hmmb?',
                'answer' => 'Himpunan Mahasiswa Manajemen Bisnis (HMMB) merupakan sebuah organisasi yang dibentuk pada tanggal 20 Maret 2012 dengan tujuan menjadi suatu organisasi yang menaungi seluruh mahasiswa jurusan Manajemen Bisnis.',
                'keywords' => 'ormawa, hmmb, manajemen bisnis, organisasi, himpunan, politeknik',
                'source' => 'https://www.instagram.com/hmmbpolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa energi?',
                'answer' => 'Entrepreneur Generation (ENERGI) merupakan Unit Kegiatan Mahasiswa (UKM) yang dibentuk pada tanggal 13 Maret 2013 dengan tujuan menjadi suatu organisasi mahasiswa yang dapat membangun jiwa dan semangat entrepreneur atau kewirausahaan mahasiswa Politeknik Negeri Batam.',
                'keywords' => 'ormawa, ukm, energi, wirausaha, politeknik, Entrepreneur Generation, kewirausahaan',
                'source' => 'https://www.instagram.com/energi_polibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa hmti?',
                'answer' => 'Himpunan Mahasiswa Teknik Informatika (HMTI) dibentuk pada tanggal 12 Maret 2008, dengan tujuan menjadi suatu organisasi yang menaungi seluruh mahasiswa jurusan Teknik Informatika. Organisasi ini tumbuh dalam mewadahi aspirasi dan kreativitas mahasiswa Teknik Informatika.',
                'keywords' => 'ormawa, organisasi, himpunan, informatika, teknik, politeknik',
                'source' => 'https://www.instagram.com/hmtipolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa immpb?',
                'answer' => 'Ikatan Mahasiswa Muslim Politeknik Negeri Batam (IMMPB) telah berdiri sejak 1 November 2001.IMMPB telah berusia 24 tahun dalam perjalanan dakwah dan pendidikan untuk membentuk generasi mahasiswa muslim Politeknik Negeri Batam yang berakhlak, cerdas, dan berintegritas. IMMPB hadir menjadi wadah yang menumbuhkan semangat keislaman dan kebersamaan, serta menjadi pelopor kebaikan di lingkungan Politeknik Negeri Batam.',
                'keywords' => 'ormawa, ukm, immpb, ikatan, muslim, politeknik, islam',
                'source' => 'https://www.instagram.com/immpbpolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa bem?',
                'answer' => 'BEM (Badan Eksekutif Mahasiswa) merupakan organisasi kemahasiswaan eksekutor tertinggi di Polibatam yang berfungsi sebagai wadah untuk menyampaikan aspirasi ataupun keluh kesah perkuliahan.',
                'keywords' => 'ormawa, bem, eksekutif, politeknik, organisasi',
                'source' => 'https://www.instagram.com/bempolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apakah ada komunitas buat anak rantau?',
                'answer' => 'Ya, di Polibatam sendiri tersedia komunitas buat anak rantau yaitu, Komunitas Anak Rantau Politeknik Negeri Batam ayang menjadi wadah bagi mahasiswa perantau untuk saling mendukung, berbagi cerita, dan menemukan keluarga baru. Komunitas ini hadir sebagai ruang aman untuk membantu mahasiswa menghadapi tantangan akademik dan adaptasi lingkungan, serta bertujuan membangun kebersamaan, dukungan emosional dan akademik, serta memperluas pertemanan.',
                'keywords' => 'rantau, komunitas, politeknik',
                'source' => 'https://www.instagram.com/p/DSE5Z7_EgYn/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=='
            ],
            [
                'question' => 'apa itu ormawa dpm?',
                'answer' => 'Dewan Perwakilan Mahasiswa (DPM) Politeknik Negeri Batam adalah lembaga legislatif mahasiswa yang berperan sebagai penyalur aspirasi, pengawas kinerja organisasi kemahasiswaan, serta penjaga keharmonisan roda pemerintahan mahasiswa di lingkungan kampus.',
                'keywords' => 'dpm, ormawa, dewan perwakilan, mahasiswa, lembaga, politeknik',
                'source' => 'https://www.instagram.com/dpmpolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa lpm?',
                'answer' => 'LPM Paradigma merupakan sebuah Unit Kegiatan Mahasiswa yang bergerak dalam bidang media komunikasi, informasi, edukasi, serta wadah aspirasi Politeknik Negeri Batam yang dibentuk pada 23 April 2008.',
                'keywords' => 'ormawa, ukm, unit kegiatan, lpm, lembaga pers, paradigma, politeknik',
                'source' => 'https://www.instagram.com/lpmpolibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa blug?',
                'answer' => 'Batam Linux User Group (BLUG) merupakan Komunitas Pecinta Linux Indonesia (KPLI) yang berlokasi di Kota Batam sebagai wadah yang digunakan untuk kegiatan pembelajaran dan pengembangan sistem operasi GNU/Linux dan Open Source Software bagi masyarakat Kota Batam umumnya dan mahasiswa Politeknik Negeri Batam. Berdiri pada tanggal 27 September 2003 di mana pada saat itu masih berstatus sebagai komunitas dan bergabung sebagai ORMAWA di Politeknik Negeri Batam pada tahun 2008 dan telah mengadakan berbagai kegiatan internal maupun eksternal.',
                'keywords' => 'ormawa, ukm, blug, batam linux user, politeknik',
                'source' => 'https://www.instagram.com/batamlinux?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => 'apa itu ormawa mapala?',
                'answer' => 'Mahasiswa Pencinta Alam Politeknik Negeri Batam atau MAPALA POLIBATAM adalah organisasi yang bergerak di bidang lingkungan, yang berdiri dengan tujuan menyadarkan orang-orang sekitar untuk turut mencintai alam, menjaga lingkungan, dan menikmati tanpa mencemari. Mapala berdiri sejak 15 Januari 2005. Organisasi ini memiliki 5 divisi (gunung, hutan, susur pantai, selam, lingkungan hidup) dan dikenal dengan program unggulan penanaman pohon serta regenerasi kepemimpinan melalui pemilihan calon ketua umum setiap tahunnya.',
                'keywords' => 'ormawa, ukm, mapala, pencinta alam, alam, politeknik, organisasi',
                'source' => 'https://www.instagram.com/mapala_polibatam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='
            ],
            [
                'question' => '',
                'answer' => '',
                'keywords' => '',
                'source' => ''
            ],
        ];

        foreach ($data as $item) {
            DB::table('organisasi_knowledge')->insert([
                'question' => $item['question'],
                'answer' => $item['answer'],
                'keywords' => $item['keywords'],
                'source' => $item['source'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}