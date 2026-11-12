<?php

use App\Models\Kelas;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register with a class', function () {
    $kelas = Kelas::create(['nama_kelas' => 'A']);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'kelas_id' => $kelas->id,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('verification.notice', absolute: false));

    $user = auth()->user();

    expect($user->role)->toBe('siswa')
        ->and($user->kelas_id)->toBe($kelas->id);
});

test('registration is rejected when no class is selected', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('kelas_id');
});
