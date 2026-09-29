<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan minimal ada kategori untuk foreign key
        $kategori1 = Kategori::where('nama_kategori', 'like', '%Operasi%')->first();
        $kategori2 = Kategori::where('nama_kategori', 'like', '%Informasi%')->first();

        if (! $kategori1) {
            $kelas1 = Kelas::firstOrCreate(['nama_kelas' => 'TK - A']);
            $kategori1 = Kategori::firstOrCreate(
                ['nama_kategori' => 'Sistem Operasi'],
                ['deskripsi' => 'Materi seputar Sistem Operasi', 'kelas_id' => $kelas1->id]
            );
        }

        if (! $kategori2) {
            $kelas2 = Kelas::where('id', '!=', $kategori1->kelas_id)->first() ?? $kategori1->kelas ?? Kelas::firstOrCreate(['nama_kelas' => 'TK - B']);
            $kategori2 = Kategori::firstOrCreate(
                ['nama_kategori' => 'Sistem Informasi'],
                ['deskripsi' => 'Materi seputar Sistem Informasi', 'kelas_id' => $kelas2->id]
            );
        }

        $materis = [
            // Kategori 1: Sistem Operasi (15 materi)
            [
                'nama_materi' => 'Pengenalan OS',
                'isi_materi'  => 'Sistem operasi adalah perangkat lunak sistem yang bertugas untuk mengelola perangkat keras dan perangkat lunak serta sebagai interface antara pengguna dan komputer.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Fungsi Dasar OS',
                'isi_materi'  => 'Fungsi dasar sistem operasi mencakup manajemen memori, pengelolaan proses, sistem berkas, pengawasan sumber daya, serta penyediaan antarmuka pengguna.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Instalasi Windows',
                'isi_materi'  => 'Proses instalasi Windows melibatkan persiapan media instalasi bootable, partisi media penyimpanan, serta konfigurasi awal akun pengguna dan koneksi jaringan.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Manajemen File',
                'isi_materi'  => 'Manajemen file dalam sistem operasi mengelola berkas secara terstruktur dalam folder dan direktori, serta mengatur hak akses baca, tulis, dan eksekusi pengguna.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Perangkat Keras',
                'isi_materi'  => 'Perangkat keras komputer seperti CPU, RAM, hard disk, dan motherboard membutuhkan driver khusus yang dikendalikan oleh sistem operasi agar dapat berfungsi optimal.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Perangkat Lunak',
                'isi_materi'  => 'Perangkat lunak dibedakan menjadi perangkat lunak sistem dan aplikasi. Sistem operasi bertindak sebagai jembatan bagi aplikasi untuk memanfaatkan hardware.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Jaringan Dasar',
                'isi_materi'  => 'Konsep jaringan dasar pada sistem operasi meliputi konfigurasi IP address, subnet mask, gateway, DNS, serta protokol komunikasi seperti TCP/IP.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Keamanan Data',
                'isi_materi'  => 'Keamanan data melibatkan proteksi file dengan enkripsi, pengaturan hak akses, penggunaan kata sandi yang kuat, dan pemanfaatan antivirus atau firewall bawaan OS.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Struktur Direktori',
                'isi_materi'  => 'Struktur direktori mengatur penempatan berkas sistem dan berkas pengguna dalam format pohon hierarkis untuk mempermudah pencarian dan pengelompokan data.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Partisi Hardisk',
                'isi_materi'  => 'Partisi hard disk membagi ruang penyimpanan menjadi beberapa drive logis seperti drive sistem (C:) dan drive data (D:) untuk efisiensi dan keamanan data.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Command Prompt',
                'isi_materi'  => 'Command Prompt atau CLI memungkinkan pengguna berinteraksi dengan sistem operasi melalui baris perintah teks untuk administrasi sistem tingkat lanjut.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Sistem Operasi GUI',
                'isi_materi'  => 'Sistem operasi berbasis GUI menyediakan antarmuka visual berupa jendela, ikon, dan menu yang ramah pengguna sehingga memudahkan navigasi bagi pemula.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Sistem Operasi CLI',
                'isi_materi'  => 'CLI menawarkan kecepatan eksekusi tinggi dan hemat sumber daya memori, sangat cocok digunakan untuk server dan otomatisasi skrip administratif.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Pengenalan Linux',
                'isi_materi'  => 'Linux adalah sistem operasi open source yang memiliki performa tinggi, stabilitas teruji, dan banyak digunakan pada infrastruktur cloud maupun server.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],
            [
                'nama_materi' => 'Virtual Machine',
                'isi_materi'  => 'Virtual machine memungkinkan satu komputer fisik menjalankan beberapa sistem operasi secara terisolasi sekaligus untuk keperluan pengujian dan edukasi.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori1->id,
            ],

            // Kategori 2: Sistem Informasi (15 materi)
            [
                'nama_materi' => 'Konsep Basis Data',
                'isi_materi'  => 'Basis data adalah kumpulan data terstruktur yang disimpan secara elektronik dan dikelola oleh DBMS untuk mendukung kebutuhan pengolahan data sistem informasi.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Sistem Informasi',
                'isi_materi'  => 'Sistem informasi mengombinasikan teknologi komputer, data, proses bisnis, dan sumber daya manusia untuk menghasilkan informasi berkualitas dalam pengambilan keputusan.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Analisis Sistem',
                'isi_materi'  => 'Analisis sistem merupakan tahapan mengidentifikasi masalah, mengumpulkan kebutuhan pengguna, dan menganalisis alur bisnis sebelum membangun sistem baru.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Desain Database',
                'isi_materi'  => 'Desain basis data meliputi pemodelan konseptual, logika relasional, hingga desain fisik tabel untuk memastikan integritas dan performa penyimpanan data.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Entity Diagram',
                'isi_materi'  => 'Entity Relationship Diagram (ERD) adalah diagram yang menggambarkan hubungan antar entitas data dalam suatu sistem secara visual dan terstruktur.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Normalisasi Data',
                'isi_materi'  => 'Normalisasi data adalah teknik perancangan basis data untuk meminimalkan redundansi dan mencegah anomali saat manipulasi data seperti insert, update, dan delete.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Query SQL Dasar',
                'isi_materi'  => 'Query SQL dasar meliputi perintah DDL dan DML seperti SELECT, INSERT, UPDATE, dan DELETE untuk mengambil dan memanipulasi informasi pada basis data.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Aliran Informasi',
                'isi_materi'  => 'Pemetaan aliran informasi menggunakan Data Flow Diagram (DFD) menggambarkan bagaimana data bergerak dari sumber eksternal ke proses dan media penyimpanan.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Siklus Hidup SDLC',
                'isi_materi'  => 'SDLC (System Development Life Cycle) mencakup tahapan perencanaan, analisis, perancangan, implementasi, pengujian, hingga pemeliharaan sistem perangkat lunak.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Testing Perangkat',
                'isi_materi'  => 'Pengujian perangkat lunak dilakukan untuk memastikan sistem bebas dari bug, memenuhi persyaratan fungsional, dan siap digunakan oleh pengguna akhir.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Implementasi SI',
                'isi_materi'  => 'Tahap implementasi sistem informasi mencakup migrasi data lama, pelatihan pengguna, konfigurasi server produksi, dan peluncuran sistem secara resmi.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Pemeliharaan SI',
                'isi_materi'  => 'Pemeliharaan sistem informasi meliputi perbaikan bug berkala, pembaruan keamanan, optimasi performa server, dan adaptasi terhadap regulasi baru.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Integrasi Sistem',
                'isi_materi'  => 'Integrasi sistem menghubungkan berbagai subsistem aplikasi yang terpisah melalui API atau middleware agar pertukaran data berjalan cepat dan otomatis.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Etika Profesi IT',
                'isi_materi'  => 'Etika profesi teknologi informasi mencakup perlindungan privasi data pengguna, hak kekayaan intelektual, transparansi algoritma, dan tanggung jawab sosial.',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
            [
                'nama_materi' => 'Cloud Computing',
                'isi_materi'  => 'Komputasi awan menyediakan layanan server, database, penyimpanan, dan jaringan melalui internet dengan model bayar sesuai pemakaian (pay-as-you-go).',
                'gambar'      => null,
                'audio'       => null,
                'kategori_id' => $kategori2->id,
            ],
        ];

        foreach ($materis as $data) {
            Materi::create($data);
        }
    }
}