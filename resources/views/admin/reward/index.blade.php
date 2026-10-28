 @extends('layouts.admin.app')

@section('title', 'Kelola Reward - BUBA')

@section('content')

<div class="p-4 sm:p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Hasil Reward Anak</h1>
        <p class="mt-1 text-sm text-gray-500">
            Daftar hasil pengerjaan kuis dan bintang yang diperoleh anak.
        </p>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-md">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-blue-600 text-xs uppercase text-white">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Nama Anak</th>
                        <th class="px-5 py-4">Kelas</th>
                        <th class="px-5 py-4">Kategori</th>
                        <th class="px-5 py-4 text-center">Benar</th>
                        <th class="px-5 py-4 text-center">Salah</th>
                        <th class="px-5 py-4 text-center">Nilai</th>
                        <th class="px-5 py-4 text-center">Bintang</th>
                        <th class="px-5 py-4">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($rewards as $index => $reward)

                        <tr class="transition hover:bg-blue-50">

                            <td class="px-5 py-4">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-5 py-4 font-semibold text-gray-800">
                                {{ $reward->user->name ?? 'Anak tidak ditemukan' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $reward->quis->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $reward->quis->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-center font-semibold text-green-600">
                                {{ $reward->jumlah_benar }}
                            </td>

                            <td class="px-5 py-4 text-center font-semibold text-red-500">
                                {{ $reward->jumlah_salah }}
                            </td>

                            <td class="px-5 py-4 text-center font-bold text-blue-600">
                                {{ $reward->skor }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if($reward->jumlah_bintang > 0)
                                    <span class="text-lg">
                                        {{ str_repeat('⭐', $reward->jumlah_bintang) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">0 ⭐</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $reward->created_at->format('d-m-Y H:i') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="px-5 py-10 text-center">
                                <div class="text-4xl">⭐</div>

                                <p class="mt-3 font-semibold text-gray-600">
                                    Belum ada hasil reward.
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Hasil kuis anak akan muncul di halaman ini.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
