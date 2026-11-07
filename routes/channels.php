<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin.data', function (User $user) {
    return $user->role === 'guru';
});

Broadcast::channel('siswa.data', function (User $user) {
    return $user->role === 'siswa';
});
