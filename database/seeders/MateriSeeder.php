<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Materi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MateriSeeder extends Seeder
{
    /**
     * Seed contoh materi untuk setiap kategori yang sudah ada.
     *
     * Seeder ini idempotent: menjalankan ulang tidak akan menggandakan
     * materi atau menimpa file gambar/audio yang sudah diunggah.
     */
    public function run(): void
    {
        $materiPerKategori = [
            'Mengenal Huruf' => [
                [
                    'nama_materi' => 'Huruf A Sampai E',
                    'isi_materi' => 'Mari mengenal huruf A, B, C, D, dan E. Huruf-huruf ini adalah awal dari banyak kata yang kita gunakan setiap hari.',
                ],
                [
                    'nama_materi' => 'Huruf Vokal',
                    'isi_materi' => 'Huruf vokal terdiri dari A, I, U, E, dan O. Huruf vokal membuat kata terdengar lebih hidup saat kita membacanya.',
                ],
            ],
            'Mengenal Angka & Berhitung' => [
                [
                    'nama_materi' => 'Angka Satu Sampai Lima',
                    'isi_materi' => 'Kita belajar angka 1, 2, 3, 4, dan 5. Coba hitung jari tanganmu satu per satu sambil menyebutkan angkanya.',
                ],
                [
                    'nama_materi' => 'Berhitung Benda',
                    'isi_materi' => 'Berhitung benda dapat dilakukan dengan menghitung bola, pensil, atau mainan di sekitar kita. Hitung dengan hati-hati dan tidak terburu-buru.',
                ],
            ],
            'Mengenal Warna' => [
                [
                    'nama_materi' => 'Warna Dasar',
                    'isi_materi' => 'Warna dasar yang sering kita lihat adalah merah, kuning, dan biru. Warna-warna ini dapat dicampur untuk membuat warna baru.',
                ],
                [
                    'nama_materi' => 'Warna Pelangi',
                    'isi_materi' => 'Pelangi memiliki warna merah, jingga, kuning, hijau, biru, dan ungu. Pelangi muncul setelah hujan saat matahari bersinar.',
                ],
            ],
            'Mengenal Bentuk' => [
                [
                    'nama_materi' => 'Bentuk Lingkaran',
                    'isi_materi' => 'Lingkaran adalah bentuk bulat tanpa sudut. Contoh benda berbentuk lingkaran adalah bola dan roda sepeda.',
                ],
                [
                    'nama_materi' => 'Bentuk Persegi',
                    'isi_materi' => 'Persegi memiliki empat sisi yang sama panjang. Benda berbentuk persegi contohnya adalah biskuit dan papan tulis.',
                ],
            ],
            'Mengenal Hewan' => [
                [
                    'nama_materi' => 'Hewan Peliharaan',
                    'isi_materi' => 'Hewan peliharaan seperti kucing, ikan, dan burung perlu diberi makan dan dijaga kebersihannya setiap hari.',
                ],
                [
                    'nama_materi' => 'Hewan Di Kebun',
                    'isi_materi' => 'Di kebun kita dapat melihat kupu-kupu, semut, dan burung. Setiap hewan memiliki tempat hidup dan makanan sendiri.',
                ],
            ],
            'Mengenal Anggota Tubuh' => [
                [
                    'nama_materi' => 'Kepala Dan Tangan',
                    'isi_materi' => 'Kepala digunakan untuk berpikir dan tangan digunakan untuk memegang benda. Kita harus menjaga keduanya tetap bersih.',
                ],
                [
                    'nama_materi' => 'Mata Dan Telinga',
                    'isi_materi' => 'Mata digunakan untuk melihat dan telinga digunakan untuk mendengar. Rawat keduanya dengan baik agar tetap sehat.',
                ],
            ],
            'Kebersihan Diri' => [
                [
                    'nama_materi' => 'Cuci Tangan',
                    'isi_materi' => 'Cuci tangan dengan sabun sebelum makan dan setelah bermain. Tangan yang bersih membuat tubuh terhindar dari kuman.',
                ],
                [
                    'nama_materi' => 'Mandi Setiap Hari',
                    'isi_materi' => 'Mandi setiap hari membuat tubuh wangi dan bersih. Gunakan air bersih dan sabun dengan bantuan orang dewasa.',
                ],
            ],
            'Mengenal Tumbuhan' => [
                [
                    'nama_materi' => 'Bagian Tumbuhan',
                    'isi_materi' => 'Tumbuhan memiliki akar, batang, daun, dan bunga. Setiap bagian memiliki tugas agar tumbuhan dapat tumbuh sehat.',
                ],
                [
                    'nama_materi' => 'Tumbuhan Di Sekitar',
                    'isi_materi' => 'Tumbuhan dapat tumbuh di halaman, kebun, dan hutan. Kita harus menyiraminya dan tidak merusak daun serta bunganya.',
                ],
            ],
            'Membaca & Menulis' => [
                [
                    'nama_materi' => 'Membaca Suku Kata',
                    'isi_materi' => 'Suku kata adalah bagian dari kata, seperti ba, bi, bu, dan bo. Dengan membaca suku kata kita dapat membaca kata dengan lancar.',
                ],
                [
                    'nama_materi' => 'Menulis Nama Sendiri',
                    'isi_materi' => 'Menulis nama sendiri dimulai dengan huruf pertama yang besar. Berlatihlah menulis perlahan agar tulisan menjadi rapi.',
                ],
            ],
            'Berhitung' => [
                [
                    'nama_materi' => 'Berhitung Sampai Sepuluh',
                    'isi_materi' => 'Mari berhitung dari 1 sampai 10 dengan suara yang jelas. Hitung benda di sekitar untuk melatih kemampuan berhitung.',
                ],
                [
                    'nama_materi' => 'Penjumlahan Sederhana',
                    'isi_materi' => 'Penjumlahan berarti menggabungkan dua kelompok benda. Misalnya, 2 bola ditambah 3 bola menjadi 5 bola.',
                ],
            ],
            'Warna' => [
                [
                    'nama_materi' => 'Mencampur Warna',
                    'isi_materi' => 'Warna dapat dicampur untuk membuat warna baru. Merah dicampur kuning menghasilkan warna jingga yang cerah.',
                ],
                [
                    'nama_materi' => 'Warna Benda',
                    'isi_materi' => 'Setiap benda di sekitar kita memiliki warna. Sebutkan warna daun, langit, dan buah kesukaanmu.',
                ],
            ],
            'Bentuk & Pola' => [
                [
                    'nama_materi' => 'Pola Bentuk',
                    'isi_materi' => 'Pola bentuk adalah susunan bentuk yang berulang. Contohnya lingkaran, persegi, lingkaran, lalu persegi lagi.',
                ],
                [
                    'nama_materi' => 'Menyusun Pola',
                    'isi_materi' => 'Kita dapat menyusun pola menggunakan balok atau kertas berwarna. Susun dengan rapi dan ulangi urutannya.',
                ],
            ],
            'Hewan & Habitat.' => [
                [
                    'nama_materi' => 'Hewan Dan Habitat',
                    'isi_materi' => 'Habitat adalah tempat tinggal hewan. Ikan hidup di air, burung di pohon, dan cacing di dalam tanah.',
                ],
                [
                    'nama_materi' => 'Hewan Darat Dan Air',
                    'isi_materi' => 'Hewan darat hidup di tanah, sedangkan hewan air hidup di laut atau sungai. Setiap hewan memiliki ciri tubuh yang sesuai.',
                ],
            ],
            'Tubuh & Kesehatan' => [
                [
                    'nama_materi' => 'Tubuh Sehat',
                    'isi_materi' => 'Tubuh yang sehat membuat kita dapat bermain dan belajar dengan semangat. Makan makanan bergizi dan istirahat yang cukup.',
                ],
                [
                    'nama_materi' => 'Menjaga Kesehatan',
                    'isi_materi' => 'Menjaga kesehatan dilakukan dengan rajin berolahraga, mencuci tangan, dan tidur tepat waktu setiap hari.',
                ],
            ],
            'Menjaga Kebersihan Diri' => [
                [
                    'nama_materi' => 'Kebersihan Diri',
                    'isi_materi' => 'Kebersihan diri meliputi mencuci tangan, menyikat gigi, dan mandi. Lakukan semuanya dengan rutin setiap hari.',
                ],
                [
                    'nama_materi' => 'Merapikan Diri',
                    'isi_materi' => 'Merapikan diri berarti menyisir rambut, memakai pakaian bersih, dan memotong kuku secara teratur.',
                ],
            ],
            'Tumbuhan' => [
                [
                    'nama_materi' => 'Tumbuhan Hijau',
                    'isi_materi' => 'Daun tumbuhan berwarna hijau karena membantu tumbuhan membuat makanan. Tumbuhan hijau banyak tumbuh di sekitar rumah.',
                ],
                [
                    'nama_materi' => 'Merawat Tanaman',
                    'isi_materi' => 'Tanaman perlu disiram dan diletakkan di tempat yang mendapat cahaya matahari. Jangan mencabut tanamannya sembarangan.',
                ],
            ],
        ];

        $kategoris = Kategori::all()->keyBy('nama_kategori');

        if ($kategoris->isEmpty()) {
            $this->call(KategoriSeeder::class);
            $kategoris = Kategori::all()->keyBy('nama_kategori');
        }

        foreach ($materiPerKategori as $namaKategori => $daftarMateri) {
            $kategori = $kategoris->get($namaKategori);

            if (! $kategori) {
                continue;
            }

            foreach ($daftarMateri as $materi) {
                $dataMateri = Materi::firstOrNew([
                    'nama_materi' => $materi['nama_materi'],
                    'kategori_id' => $kategori->id,
                    'kelas_id' => $kategori->kelas_id,
                ]);

                if (! $dataMateri->exists) {
                    do {
                        $kode = 'MTR-'.Str::upper(Str::random(4));
                    } while (Materi::where('kode_materi', $kode)->exists());

                    $dataMateri->kode_materi = $kode;
                }

                $dataMateri->isi_materi = $materi['isi_materi'];
                $dataMateri->save();
            }
        }
    }
}
