<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    /**
     * Seed data guru dan tenaga kependidikan.
     *
     * Role yang tersedia pada tabel users hanya "guru" dan "siswa",
     * sehingga data tendik (kepala sekolah) ikut disimpan sebagai "guru".
     */
    public function run(): void
    {
        $daftarGuru = [
            [
                'name' => 'NUR JANNAH',
                'email' => 'nurjannah@tkdwp2kapongan.sch.id',
                'jenis_kelamin' => 'P',
            ],
            [
                'name' => "SITI HALIMATUS SA'DIYAH",
                'email' => 'sitihalimatussakdiyah@tkdwp2kapongan.sch.id',
                'jenis_kelamin' => 'P',
            ],
            [
                'name' => 'ASMIYATI',
                'email' => 'asmiyati@tkdwp2kapongan.sch.id',
                'jenis_kelamin' => 'P',
            ],
        ];

        foreach ($daftarGuru as $guru) {
            $user = User::firstOrNew(['email' => $guru['email']]);

            if (! $user->exists) {
                $user->kode_user = $this->buatKodeUser('guru');
            }

            $user->fill([
                'name' => $guru['name'],
                'jenis_kelamin' => $guru['jenis_kelamin'],
                'role' => 'guru',
                'password' => Hash::make('guru123'),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            $user->save();
        }
    }

    private function buatKodeUser(string $role): string
    {
        $prefix = $role === 'guru' ? 'TCR' : 'STD';

        do {
            $kode = $prefix.'-'.Str::upper(Str::random(4));
        } while (User::where('kode_user', $kode)->exists());

        return $kode;
    }
}
