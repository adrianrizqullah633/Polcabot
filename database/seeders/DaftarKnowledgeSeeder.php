<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'question' => 'Bagaimana cara daftar kuliah di Polibatam?',
                'answer' => 'Untuk mendaftar kuliah di Polibatam, Anda dapat mengikuti langkah-langkah berikut: 1. Kunjungi situs resmi Polibatam di https://polibatam.ac.id. 2. Cari informasi tentang penerimaan mahasiswa baru. 3. Isi formulir pendaftaran online dengan data yang benar. 4. Unggah dokumen yang diperlukan seperti ijazah, transkrip nilai, dan pas foto. 5. Bayar biaya pendaftaran sesuai dengan petunjuk yang diberikan. 6. Tunggu pengumuman hasil seleksi.',
                'keywords' => 'daftar, kuliah, polibatam',
                'source' => 'https://polibatam.ac.id'
            ],
            [
                'question' => 'Bagaimana cara daftar ulang bagi mahasiswa baru',
                'answer' => 'Peserta ujian masuk Politeknik Negeri Batam yang sudah dinyatakan lulus dan diterima dapat melakukan daftar ulang dengan cara menyelesaikan proses pembayaran UKT dan melengkapi isian data diri, tahapannya sebagai berikut: 1. Calon mahasiswa baru mengunjungi laman web berikut "https://registrasi.polibatam.ac.id/daftar_ulang/" kemudian memilih jalur masuk yang sesuai dan benar. 2. Login menggunakan nomor ujian dan tanggal lahir. 3. Memilih "Buat Kode Pembayaran". 4. Memilih pembayaran antara Bank BNI atau BTN Syariah. 5. Mengisi alamat Email yang masih aktif untuk menerima kode pembayaran. 6. Setelah mengisi email, silahkan klik tombol "Buat Kode Pembayaran". 7. Silahkan cek email yang telah dimasukkan untuk melihat kode pembayaran (Kode virtual account berlaku selama 1x24 jam). 8. Melakukan pembayaran sesuai dengan nomor VA dan nominal tagihan. 8. Silakan periksa kembali status pembayaran anda, status akan berubah menjadi “sudah bayar”. 9. Jika pembayaran sudah konfirmasi, silakan melengkapi data diri pada menu “isi data diri”. 10.  Kolom isian No KTP, dan NISN WAJIB DIISI, untuk keperluan pelaporan kepada KEMDIKBUD. 11. Lengkapi semua isian data diri dengan benar dan dapat dipertanggung jawabkan. 12. Pastikan menekan tombol “Simpan” supaya data yang sudah diisi tersimpan. 13. Jika sudah melengkapi data diri dengan benar maka langkah berikutnya adalah mengirimkan berkas persyaratan daftar ulang melalui email.',
                'keywords' => 'daftar  ulang, mahasiswa baru, maba',
                'source' => 'https://registrasi.polibatam.ac.id/daftar_ulang/petunjuk/panduan_daftar_ulang_new.pdf'
            ],
            [
                'question' => 'Bagaimana jika ingin mengajukan angsuran UKT untuk mahasiswa baru',
                'answer' => 'Untuk mengajukan angsuran Uang Kuliah Tunggal (UKT) sebagai mahasiswa baru perlu mengikuti langkah-langkah sebagai berikut: 1. Akses Portal SILAM: Kunjungi laman SILAM Polibatam. 2. Login: Masuk ke aplikasi menggunakan username dan password. 3. Pilih Menu Pelayanan: Di dalam dashboard, navigasikan ke menu Pelayanan Mahasiswa, lalu pilih Pelayanan UKT, dan terakhir klik Angsuran UKT. 4. Isi Data Pengajuan: Ikuti petunjuk di layar untuk mengisi nominal angsuran yang diajukan dan melengkapi data pendukung yang diperlukan. Pastikan Anda mengisi nominal dengan benar dan teliti. 5. Ajukan Permohonan: Kirimkan permohonan Anda melalui sistem. 6. Tunggu Persetujuan: Pihak Polibatam akan memproses pengajuan Anda. Proses selesai setelah permohonan Anda disetujui.',
                'keywords' => 'angsuran, UKT, mahasiswa baru',
                'source' => 'https://sim.polibatam.ac.id/index.php?page=keringanan_ukt'
            ],
            [
                'question' => 'Bagaimana jika ingin mengajukan perubahan untuk mahasiswa baru?',
                'answer' => 'Untuk saat ini PolCaBot belum bisa memberikan jawaban kompleks, untuk info lebih lengkapnya silahkan datang ke pusat informasi.',
                'keywords' => 'perubahan, mahasiswa baru, maba',
                'source' => '-'
            ],
            [
                'question' => 'Kapan terakhir kali jadwal Daftar Ulang?',
                'answer' => 'Jadwal daftar ulang bisa dicek melalui situs resmi "registrasi.polibatam.ac.id" atau "sim.polibatam.ac.id" dengan mencari bagian "pengumuman" untuk melihat jadwal terbaru ',
                'keywords' => 'terakhir, jadwal, daftar ulang',
                'source' => 'registrasi.polibatam.ac.id'
            ],
            [
                'question' => 'Berkas apa saja yang perlu diupload untuk daftar ulang?',
                'answer' => 'Untuk daftar ulang di Polibatam, Anda perlu mengunggah dokumen penting seperti scan Ijazah/SKL, KTP, KK, Bukti Pembayaran UKT, serta dokumen pendukung lainnya seperti Surat Keterangan Tidak Mampu (SKTM) atau bukti ekonomi jika mengajukan KIP-K, melalui laman registrasi.polibatam.ac.id setelah login dengan nomor ujian dan tanggal lahir Anda, lalu ikuti alur pengisian biodata dan verifikasi dokumen.',
                'keywords' => 'berkas, upload, daftar ulang',
                'source' => 'https://registrasi.polibatam.ac.id/wp-content/uploads/2025/03/035-Pengumuman-Daftar-Ulang-Jalur-SNBP-Tahun-2025.pdf'
            ],
            [
                'question' => 'Surat Buta Warna apakah harus dari rumah sakit atau tidak pada saat daftar ulang?',
                'answer' => 'Surat buta warna pada proses daftar ulang tidak mengharuskan dari rumah sakit tapi bisa Klinik asal menerangkan dia tidak buta warna',
                'keywords' => 'surat, buta warna, daftar ulang',
                'source' => '-'
            ],
            [
                'question' => 'Pengumuman terkait Ruang Ujian dan Jadwal Ujian UTS dan AAS?',
                'answer' => 'jadwal ada di pengumuman yang di bagikan (bisa dicek di web registrasi polibatam bagian pengumuman) ataupun di media sosial perjurusan serta media sosial resmi Polibatam',
                'keywords' => 'pengumuman, ujian, ruang, jadwal',
                'source' => '-'
            ],
            [
                'question' => '',
                'answer' => '',
                'keywords' => '',
                'source' => ''
            ],
        ];

        foreach ($data as $item) {
            DB::table('daftar_knowledge')->insert([
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