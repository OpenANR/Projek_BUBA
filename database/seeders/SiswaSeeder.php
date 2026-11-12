<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    /**
     * Seed data siswa beserta kelasnya.
     *
     * Data diambil dari database/data/PD.xlsx. Nilai kolom "Rombel Saat Ini"
     * (A/B) digunakan sebagai nama kelas.
     */
    public function run(): void
    {
        $daftarSiswa = [
            ['name' => 'BILQIS BAHIRA AZZAHRA', 'nisn' => '3212392501', 'jenis_kelamin' => 'P', 'rombel' => 'B'],
            ['name' => 'DALIYA KARIMATUN NISA', 'nisn' => '3206095003', 'jenis_kelamin' => 'P', 'rombel' => 'B'],
            ['name' => 'DILAN AL FATIH', 'nisn' => '3206048720', 'jenis_kelamin' => 'L', 'rombel' => 'B'],
            ['name' => 'EHSAN EVANO FAEZAH', 'nisn' => '3214509089', 'jenis_kelamin' => 'L', 'rombel' => 'A'],
            ['name' => 'FINA ATHIYATUL MAULA', 'nisn' => '3222608071', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'MOH. JAINAL HAFIZ NUR ARIFIN', 'nisn' => '3206667722', 'jenis_kelamin' => 'L', 'rombel' => 'B'],
            ['name' => 'MUHAMMAD DAVID AL-FARIZI', 'nisn' => '3209422362', 'jenis_kelamin' => 'L', 'rombel' => 'B'],
            ['name' => 'MUHAMMAD HAFIZ RAMADHANI', 'nisn' => '3219075318', 'jenis_kelamin' => 'L', 'rombel' => 'A'],
            ['name' => 'MUHAMMAD KAHFIL WARO KURNIAWAN', 'nisn' => '3205518552', 'jenis_kelamin' => 'L', 'rombel' => 'B'],
            ['name' => 'NAAFISAH ANISA NOVIANA', 'nisn' => '3212727664', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'NABILA KURROTUL AINI', 'nisn' => '3216731976', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'NADIRA RIZQIANA AZZAHRA', 'nisn' => '3224206294', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'ROBIATIL AMAIRA', 'nisn' => '3223319802', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'RUHIL QUDSI MAHBUBUR ROHMANI', 'nisn' => '3218895402', 'jenis_kelamin' => 'L', 'rombel' => 'A'],
            ['name' => 'VIOLA CAIRA', 'nisn' => '3210385034', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'WILDATUL HASANA', 'nisn' => '3218484928', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'YASMIN WULIDA FARHANA', 'nisn' => '3216163374', 'jenis_kelamin' => 'P', 'rombel' => 'B'],
            ['name' => 'ZAHRO WULIDA FARIHA', 'nisn' => '3216893333', 'jenis_kelamin' => 'P', 'rombel' => 'B'],
            ['name' => 'ZAHROTUL INAYAH', 'nisn' => '3215015478', 'jenis_kelamin' => 'P', 'rombel' => 'A'],
            ['name' => 'ZAKIYAH AFKARINA', 'nisn' => '3209415568', 'jenis_kelamin' => 'P', 'rombel' => 'B'],
        ];

        $daftarKelas = [];

        foreach (array_unique(array_column($daftarSiswa, 'rombel')) as $namaKelas) {
            $daftarKelas[$namaKelas] = Kelas::firstOrCreate(['nama_kelas' => $namaKelas]);
        }

        foreach ($daftarSiswa as $siswa) {
            $email = sprintf('siswa.%s@example.test', $siswa['nisn']);

            $user = User::firstOrNew(['email' => $email]);

            if (! $user->exists) {
                $user->kode_user = $this->buatKodeUser('siswa');
            }

            $user->fill([
                'name' => $siswa['name'],
                'jenis_kelamin' => $siswa['jenis_kelamin'],
                'role' => 'siswa',
                'kelas_id' => $daftarKelas[$siswa['rombel']]->id,
                'password' => Hash::make('siswa123'),
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
