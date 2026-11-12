<?php

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

function buatKelasDanKategori(string $namaKelas, string $namaKategori, string $slug): array
{
    $kelas = Kelas::create(['nama_kelas' => $namaKelas]);
    $kategori = Kategori::create([
        'nama_kategori' => $namaKategori,
        'deskripsi' => 'Deskripsi '.$namaKategori,
        'slug' => $slug,
        'kelas_id' => $kelas->id,
    ]);

    return [$kelas, $kategori];
}

it('rejects web material pages when the category belongs to another class', function () {
    $this->withoutVite();

    [$kelasA] = buatKelasDanKategori('A', 'Kategori A', 'kategori-a');
    [, $kategoriB] = buatKelasDanKategori('B', 'Kategori B', 'kategori-b');

    $siswa = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelasA->id]);

    $this->actingAs($siswa)
        ->get(route('siswa.materi', [
            'konten' => 'materi',
            'kelas' => $kelasA->nama_kelas,
            'kategori' => $kategoriB->slug,
        ]))
        ->assertNotFound();
});

it('rejects saving or updating materials with a category from another class', function () {
    [$kelasA, $kategoriA] = buatKelasDanKategori('A', 'Kategori A', 'kategori-a');
    [, $kategoriB] = buatKelasDanKategori('B', 'Kategori B', 'kategori-b');

    $guru = User::factory()->create(['role' => 'guru']);

    $this->actingAs($guru)
        ->post(route('materi.kirim'), [
            'nama_materi' => 'Materi Baru',
            'kategori_id' => $kategoriB->id,
            'kelas_id' => $kelasA->id,
            'isi_materi' => 'Isi materi baru.',
        ])
        ->assertSessionHasErrors('kategori_id');

    $materi = Materi::create([
        'nama_materi' => 'Materi Lama',
        'isi_materi' => 'Isi materi lama.',
        'kategori_id' => $kategoriA->id,
        'kelas_id' => $kelasA->id,
    ]);

    $this->actingAs($guru)
        ->put(route('materi.update', $materi), [
            'nama_materi' => 'Materi Lama',
            'kategori_id' => $kategoriB->id,
            'kelas_id' => $kelasA->id,
            'isi_materi' => 'Isi materi lama.',
        ])
        ->assertSessionHasErrors('kategori_id');

    expect($materi->fresh()->kategori_id)->toBe($kategoriA->id);
});

it('rejects API material and quiz requests with a category from another class', function () {
    [$kelasA] = buatKelasDanKategori('A', 'Kategori A', 'kategori-a');
    [, $kategoriB] = buatKelasDanKategori('B', 'Kategori B', 'kategori-b');

    $siswa = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelasA->id]);
    $this->actingAs($siswa, 'sanctum');

    $this->getJson('/api/siswa/materi?kelas_id='.$kelasA->id.'&kategori_id='.$kategoriB->id)
        ->assertStatus(422)
        ->assertJsonValidationErrors('kategori_id');

    $this->getJson('/api/siswa/kuis?kelas_id='.$kelasA->id.'&kategori_id='.$kategoriB->id)
        ->assertStatus(422)
        ->assertJsonValidationErrors('kategori_id');

    $this->postJson('/api/siswa/kuis/submit', [
        'quis_id' => 1,
        'kelas_id' => $kelasA->id,
        'kategori_id' => $kategoriB->id,
        'jawaban' => [1 => 'A'],
    ])->assertStatus(422)
        ->assertJsonValidationErrors('kategori_id');
});

it('deletes related material and quiz files when a category is deleted', function () {
    Storage::fake('public');

    [$kelas, $kategori] = buatKelasDanKategori('A', 'Kategori A', 'kategori-a');

    Storage::disk('public')->put('materi/gambar.png', 'gambar');
    Storage::disk('public')->put('audio/materi.mp3', 'audio');
    Storage::disk('public')->put('quis/gambar.png', 'gambar');
    Storage::disk('public')->put('quis/audio.mp3', 'audio');

    Materi::create([
        'nama_materi' => 'Materi Uji',
        'isi_materi' => 'Isi materi uji.',
        'gambar' => 'materi/gambar.png',
        'audio' => 'audio/materi.mp3',
        'kategori_id' => $kategori->id,
        'kelas_id' => $kelas->id,
    ]);

    Quis::create([
        'kelas_id' => $kelas->id,
        'kategori_id' => $kategori->id,
        'pertanyaan' => 'Pertanyaan uji?',
        'gambar' => ['quis/gambar.png'],
        'audio_pertanyaan' => 'quis/audio.mp3',
        'pilihan_a' => 'A',
        'pilihan_b' => 'B',
        'pilihan_c' => 'C',
        'pilihan_d' => 'D',
        'jawaban' => 'A',
    ]);

    $guru = User::factory()->create(['role' => 'guru']);

    $this->actingAs($guru)
        ->delete(route('kategori.hapus', $kategori->id))
        ->assertRedirect(route('kategori.index'));

    $this->assertDatabaseMissing('kategoris', ['id' => $kategori->id]);
    $this->assertDatabaseMissing('materis', ['kategori_id' => $kategori->id]);
    $this->assertDatabaseMissing('quis', ['kategori_id' => $kategori->id]);

    Storage::disk('public')->assertMissing('materi/gambar.png');
    Storage::disk('public')->assertMissing('audio/materi.mp3');
    Storage::disk('public')->assertMissing('quis/gambar.png');
    Storage::disk('public')->assertMissing('quis/audio.mp3');
});

it('can run all seeders twice without duplicating data or leaving users unverified', function () {
    $this->seed();
    $this->seed();

    expect(Kelas::count())->toBe(2)
        ->and(Kategori::count())->toBe(16)
        ->and(Materi::count())->toBe(32)
        ->and(User::count())->toBe(24)
        ->and(User::whereNull('email_verified_at')->count())->toBe(0);
});

it('rate limits repeated API login attempts', function () {
    $email = 'tidak-ada@example.test';

    for ($i = 0; $i < 5; $i++) {
        $this->postJson('/api/login', [
            'email' => $email,
            'password' => 'salah',
        ])->assertStatus(401);
    }

    $this->postJson('/api/login', [
        'email' => $email,
        'password' => 'salah',
    ])->assertStatus(429)
        ->assertJsonPath('success', false);
});

it('ships Indonesian validation messages', function () {
    expect(trans('validation.required', ['attribute' => 'nama']))
        ->toBe('Kolom nama wajib diisi.')
        ->and(trans('auth.failed'))
        ->toBe('Email atau kata sandi yang dimasukkan tidak sesuai.');
});
