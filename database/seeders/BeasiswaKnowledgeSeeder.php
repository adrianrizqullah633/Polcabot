<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeasiswaKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'question' => 'Apakah ada beasiswa di Polibatam?',
                'answer' => 'Ada, yaitu beasiswa yang ditawarkan oleh Polibatam untuk mahasiswa baru dan mahasiswa aktif. Informasi lebih lanjut dapat ditemukan di situs resmi Polibatam.',
                'keywords' => 'beasiswa, polibatam, apakah',
                'source' => 'https://polibatam.ac.id'
            ],
            [
                'question' => 'apa itu beasiswa bankesma?',
                'answer' => 'Beasiswa Bank Kesejahteraan Mahasiswa (BANKESMA) program beasiswa ini merupakan bentuk nyata kepedulian BEM Polibatam melalui Kementerian Dalam Negeri, yang berkomitmen membantu meringankan beban finansial mahasiswa Polibatam agar bisa tetap fokus menempuh pendidikan dengan semangat. Informasi beasiswa ini biasanya akan dipublikasikan melalui instagram BEM Politeknik Negeri Batam ',
                'keywords' => 'beasiswa, bankesma, mahasiswa, politeknik, bem',
                'source' => ''
            ],
            [
                'question' => 'Apa saja beasiswa yang ada di Polibatam?',
                'answer' => '1. Beasiswa Swadana Semester Ganjil 2. Beasiswa Bank Indonesia 3. Beasiswa Penerbit Erlangga 4. Beasiswa Mahasiswa Berprestasi dan Berkepribadian Unggul 5. Beasiswa Swadana Semester Genap 6. Beasiswa Bank Mandiri 7. Beasiswa Aktifitas Kemahasiswaan ',
                'keywords' => 'beasiswa, polibatam, swadana, bank, berprestasi',
                'source' => ''
            ],
            [
                'question' => '',
                'answer' => '',
                'keywords' => '',
                'source' => ''
            ],
            [
                'question' => '',
                'answer' => '',
                'keywords' => '',
                'source' => ''
            ],
        ];

        foreach ($data as $item) {
            DB::table('beasiswa_knowledge')->insert([
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