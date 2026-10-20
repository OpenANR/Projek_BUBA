<?php

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\User;

it('connects newly created classes to their categories and materials', function () {
    $this->withoutVite();

    $kelas = Kelas::create(['nama_kelas' => 'KELAS1']);
    $kategori = Kategori::create([
        'nama_kategori' => 'Mengenal Huruf',
        'deskripsi' => 'Belajar mengenal huruf.',
        'kelas_id' => $kelas->id,
    ]);

    $siswa = User::factory()->create(['role' => 'siswa']);
    $this->actingAs($siswa);

    $pilihKelas = $this->get(route('siswa.kelas', ['konten' => 'materi']));
    $pilihKelas->assertOk()
        ->assertSee('KELAS1')
        ->assertSee(route('siswa.kategori', [
            'konten' => 'materi',
            'kelas' => $kelas->id,
        ]));

    $halamanKategori = $this->get(route('siswa.kategori', [
        'konten' => 'materi',
        'kelas' => $kelas->id,
    ]));
    $halamanKategori->assertOk()
        ->assertSee('Mengenal Huruf')
        ->assertSee(route('siswa.materi', [
            'konten' => 'materi',
            'kelas' => $kelas->id,
            'kategori' => $kategori->id,
        ]));

    $this->get(route('siswa.materi', [
        'konten' => 'materi',
        'kelas' => $kelas->id,
        'kategori' => $kategori->id,
    ]))->assertOk()
        ->assertSee('Materi belum tersedia');
});
