<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKategori = [
            
            /**
             * ====================================
             *     DATA KATEGORI UNTUK KELAS A
             * ====================================
             */
            [
                'nama_kategori' => 'Mengenal Huruf',
                'deskripsi'     => 'Siswa mengenal berbagai macam huruf.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Angka & Berhitung',
                'deskripsi'     => 'Siswa mengenal berbagai macam angka dan belajar menghitung',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Warna',
                'deskripsi'     => 'Siswa mengenal berbagai macam warna.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Bentuk',
                'deskripsi'     => 'Siswa mengenal berbagai macam bentuk.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Hewan',
                'deskripsi'     => 'Siswa mengenal berbagai macam jenis hewan.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Anggota Tubuh',
                'deskripsi'     => 'Siswa mengenal anggota tubuh diri sendiri.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Kebersihan Diri',
                'deskripsi'     => 'Siswa mempelajari kebersihan diri.',
                'kelas_id'      => 1,
            ],
            [
                'nama_kategori' => 'Mengenal Tumbuhan',
                'deskripsi'     => 'Siswa mengenal berbagai macam tumbuhan.',
                'kelas_id'      => 1,
            ],

            /**
             * ====================================
             *     DATA KATEGORI UNTUK KELAS B
             * ====================================
             */

            [
                'nama_kategori' => 'Membaca & Menulis',
                'deskripsi'     => 'Siswa diajari membaca dan menulis dengan baik dan benar.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Berhitung',
                'deskripsi'     => 'Siswa diajari cara berhitung yang baik dan benar.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Warna',
                'deskripsi'     => 'Siswa mempelajari warna dengan baik dan benar.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Bentuk & Pola',
                'deskripsi'     => 'Siswa mempelajari bentuk dan pola dengna baik dan benar.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Hewan & Habitat.',
                'deskripsi'     => 'Siswa diajari untuk mengenal hewan dan habitat aslinya.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Tubuh & Kesehatan',
                'deskripsi'     => 'Siswa diajari mengenal tubuh dan menjaga kesehatan dengan sangat baik.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Menjaga Kebersihan Diri',
                'deskripsi'     => 'Siswa diajari untuk menjaga kebersihan diri dengan sangat baik.',
                'kelas_id'      => 2,
            ],
            [
                'nama_kategori' => 'Tumbuhan',
                'deskripsi'     => 'Siswa diajari untuk mempelajari tumbuhan dengan sangat baik.',
                'kelas_id'      => 2,
            ],
        ];

        foreach ($dataKategori as $item){
            Kategori::updateOrCreate(
                [
                    'nama_kategori' => $item['nama_kategori'],
                    'kelas_id'      => $item['kelas_id'],
                ],
                [
                    'deskripsi'     => $item['deskripsi'],
                    'slug'          => Str::slug($item['nama_kategori']),
                ]
            );
        }
    }
}
