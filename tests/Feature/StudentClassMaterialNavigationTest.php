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
        'slug' => 'mengenal-huruf',
        'kelas_id' => $kelas->id,
    ]);

    $siswa = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelas->id,
    ]);
    $this->actingAs($siswa);

    $pilihKelas = $this->get(route('siswa.kelas', ['konten' => 'materi']));
    $pilihKelas->assertOk()
        ->assertSee('KELAS1')
        ->assertSee(route('siswa.kategori', [
            'konten' => 'materi',
            'kelas' => $kelas->nama_kelas,
        ]));

    $halamanKategori = $this->get(route('siswa.kategori', [
        'konten' => 'materi',
        'kelas' => $kelas->nama_kelas,
    ]));
    $halamanKategori->assertOk()
        ->assertSee('Mengenal Huruf')
        ->assertSee(route('siswa.materi', [
            'konten' => 'materi',
            'kelas' => $kelas->nama_kelas,
            'kategori' => $kategori->slug,
        ]));

    $this->get(route('siswa.materi', [
        'konten' => 'materi',
        'kelas' => $kelas->nama_kelas,
        'kategori' => $kategori->slug,
    ]))->assertOk()
        ->assertSee('Belum Ada Materi');
});

it('displays the content selection page with materi and kuis options and back navigation', function () {
    $this->withoutVite();

    $siswa = User::factory()->create(['role' => 'siswa']);
    $this->actingAs($siswa);

    $response = $this->get(route('siswa.konten'));
    $response->assertOk()
        ->assertSee('PILIH KONTEN')
        ->assertSee('MATERI')
        ->assertSee('KUIS')
        ->assertSee(route('siswa.kelas', ['konten' => 'materi']))
        ->assertSee(route('siswa.kelas', ['konten' => 'kuis']))
        ->assertSee(route('siswa.splash'));
});

it('shows only the signed-in student class and rejects other web class routes', function () {
    $this->withoutVite();

    $kelasA = Kelas::create(['nama_kelas' => 'A']);
    $kelasB = Kelas::create(['nama_kelas' => 'B']);
    $kategoriA = Kategori::create([
        'nama_kategori' => 'Kategori A',
        'deskripsi' => 'Kategori kelas A.',
        'slug' => 'kategori-a',
        'kelas_id' => $kelasA->id,
    ]);
    $kategoriB = Kategori::create([
        'nama_kategori' => 'Kategori B',
        'deskripsi' => 'Kategori kelas B.',
        'slug' => 'kategori-b',
        'kelas_id' => $kelasB->id,
    ]);

    $siswaA = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelasA->id,
    ]);
    $siswaB = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelasB->id,
    ]);

    foreach ([[$siswaA, $kelasA, $kelasB], [$siswaB, $kelasB, $kelasA]] as [$siswa, $kelasMilikSiswa, $kelasLain]) {
        $this->actingAs($siswa);

        $this->get(route('siswa.kelas', ['konten' => 'materi']))
            ->assertOk()
            ->assertSee(route('siswa.kategori', [
                'konten' => 'materi',
                'kelas' => $kelasMilikSiswa->nama_kelas,
            ]))
            ->assertDontSee(route('siswa.kategori', [
                'konten' => 'materi',
                'kelas' => $kelasLain->nama_kelas,
            ]));

        $this->get(route('siswa.kategori', [
            'konten' => 'materi',
            'kelas' => $kelasLain->nama_kelas,
        ]))->assertForbidden();
    }

    $this->actingAs($siswaA);

    $this->get(route('siswa.materi', [
        'konten' => 'materi',
        'kelas' => $kelasB->nama_kelas,
        'kategori' => $kategoriB->slug,
    ]))->assertForbidden();

    $this->get(route('siswa.showMateri', [
        'konten' => 'materi',
        'kelas' => $kelasB->nama_kelas,
        'kategori' => $kategoriB->slug,
        'materi' => 'MTR-NOTFOUND',
    ]))->assertForbidden();

    $this->get(route('siswa.kuis', [
        'konten' => 'kuis',
        'kelas' => $kelasB->nama_kelas,
        'kategori' => $kategoriB->slug,
    ]))->assertForbidden();

    $this->get(route('siswa.showKuis', [
        'konten' => 'kuis',
        'kelas' => $kelasB->nama_kelas,
        'kategori' => $kategoriB->slug,
        'kuis' => 'KUIS-NOTFOUND',
    ]))->assertForbidden();

    $this->post(route('siswa.simpanHasil', [
        'konten' => 'kuis',
        'kelas' => $kelasB->nama_kelas,
        'kategori' => $kategoriB->slug,
        'kuis' => 'KUIS-NOTFOUND',
    ]))->assertForbidden();
});

it('shows an unassigned student a message and no class choices', function () {
    $this->withoutVite();

    $kelas = Kelas::create(['nama_kelas' => 'A']);
    $siswa = User::factory()->create(['role' => 'siswa']);
    $this->actingAs($siswa);

    $this->get(route('siswa.kelas', ['konten' => 'materi']))
        ->assertOk()
        ->assertSee('Akun kamu belum terdaftar di kelas mana pun.')
        ->assertDontSee(route('siswa.kategori', [
            'konten' => 'materi',
            'kelas' => $kelas->nama_kelas,
        ]));

    $this->get(route('siswa.kategori', [
        'konten' => 'materi',
        'kelas' => $kelas->nama_kelas,
    ]))->assertForbidden();
});

it('limits student API class data and rejects other class requests', function () {
    $kelasA = Kelas::create(['nama_kelas' => 'A']);
    $kelasB = Kelas::create(['nama_kelas' => 'B']);
    $kategoriA = Kategori::create([
        'nama_kategori' => 'Kategori A',
        'deskripsi' => 'Kategori kelas A.',
        'slug' => 'api-kategori-a',
        'kelas_id' => $kelasA->id,
    ]);
    $kategoriB = Kategori::create([
        'nama_kategori' => 'Kategori B',
        'deskripsi' => 'Kategori kelas B.',
        'slug' => 'api-kategori-b',
        'kelas_id' => $kelasB->id,
    ]);
    $materiB = \App\Models\Materi::create([
        'nama_materi' => 'Materi B',
        'isi_materi' => 'Isi materi kelas B.',
        'kategori_id' => $kategoriB->id,
        'kelas_id' => $kelasB->id,
    ]);

    $siswaA = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelasA->id,
    ]);
    $this->actingAs($siswaA, 'sanctum');

    $this->getJson('/api/siswa/kelas')
        ->assertOk()
        ->assertJsonCount(1, 'kelas')
        ->assertJsonPath('kelas.0.id', $kelasA->id);

    $this->getJson('/api/siswa/kategori/' . $kelasB->id)->assertForbidden();
    $this->getJson('/api/siswa/materi?kelas_id=' . $kelasB->id . '&kategori_id=' . $kategoriB->id)->assertForbidden();
    $this->getJson('/api/siswa/materi/' . $materiB->kode_materi)->assertForbidden();
    $this->getJson('/api/siswa/kuis?kelas_id=' . $kelasB->id . '&kategori_id=' . $kategoriB->id)->assertForbidden();
    $this->postJson('/api/siswa/kuis/submit', [
        'kelas_id' => $kelasB->id,
        'kategori_id' => $kategoriB->id,
        'jawaban' => [1 => 'A'],
    ])->assertForbidden();

    $siswaB = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelasB->id,
    ]);
    $this->actingAs($siswaB, 'sanctum');

    $this->getJson('/api/siswa/kelas')
        ->assertOk()
        ->assertJsonCount(1, 'kelas')
        ->assertJsonPath('kelas.0.id', $kelasB->id);

    $this->getJson('/api/siswa/kategori/' . $kelasA->id)->assertForbidden();
});

