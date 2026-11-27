<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});

test('reset password notification uses custom indonesian BUBA email template', function () {
    $user = User::factory()->create([
        'name' => 'Budi Pratama',
        'email' => 'budi@example.com',
    ]);

    $notification = new ResetPassword('test-reset-token-123');
    $mailMessage = $notification->toMail($user);

    expect($mailMessage->subject)->toBe('Atur Ulang Kata Sandi - BUBA');
    expect($mailMessage->view)->toBe([
        'html' => 'emails.reset-password',
        'text' => 'emails.reset-password-text',
    ]);

    $renderedHtml = (string) $mailMessage->render();

    expect($renderedHtml)
        ->toContain('ATUR ULANG KATA SANDI')
        ->toContain('Halo, Budi Pratama!')
        ->toContain('test-reset-token-123')
        ->toContain(urlencode('budi@example.com'))
        ->toContain('60 menit');

    $renderedText = view('emails.reset-password-text', $mailMessage->viewData)->render();

    expect($renderedText)
        ->toContain('Halo, Budi Pratama!')
        ->toContain('test-reset-token-123')
        ->toContain('60 menit');
});
