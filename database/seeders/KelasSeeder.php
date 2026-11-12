<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKelas = [
            [
                'nama_kelas' => 'A'
            ],
            [
                'nama_kelas' => 'B'
            ]
        ];

        foreach($dataKelas as $item){
            Kelas::create($item);
        }
    }
}
