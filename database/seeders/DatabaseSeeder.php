<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email'=> 'admin@example.com'],
            [
                'kode_user' => 'TCR-4GT4',
                'name'      => 'Ahmad Nuzulur Rozaq',
                'password'  => Hash::make('admin123'),
                'role'      => 'guru'
            ]
        );

        $this->call([
            GuruSeeder::class,
            KelasSeeder::class,
            KategoriSeeder::class,
            SiswaSeeder::class,
            // MateriSeeder::class,
        ]);
    }
}
