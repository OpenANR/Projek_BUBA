@extends('layouts.admin.app')
@section('title', 'Kelola Kategori - BUBA')

@section('content')
<<<<<<< HEAD
<body>
    <h1>KELOLA KATEGORI</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->kelas->nama_kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection
=======
	<div class="max-w-6xl mx-auto">
		<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
			<div>
				<h1 class="text-3xl font-bold text-black">🏷️Kelola Kategori</h1>
				<p class="text-slate-400 text-sm mt-1">Kelola daftar kategori pembelajaran BUBA</p>
			</div>
			<a href="{{ route('kategori.tambah') }}"
				class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
				<i class="fas fa-plus" aria-hidden="true"></i>
				Tambah Kategori
			</a>
		</div>

		@if (session('success'))
			<div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="status">
				{{ session('success') }}
			</div>
		@endif

		@if (session('error'))
			<div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
				{{ session('error') }}
			</div>
		@endif

		<div class="bg-white text-gray-800 rounded-xl shadow-md p-6">
			<div class="flex items-center justify-between mb-4">
				<h2 class="text-lg font-semibold">Daftar Kategori</h2>
				<span class="text-sm text-gray-500">{{ $kategori->count() }} kategori</span>
			</div>
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200 text-left">
					<thead class="bg-gray-50">
						<tr>
							<th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
							<th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kategori</th>
							<th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
							<th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-100">
						@forelse ($kategori as $item)
							<tr class="hover:bg-gray-50 transition">
								<td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
								<td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $item->nama_kategori }}</td>
								<td class="px-4 py-3 text-sm text-gray-700">{{ $item->deskripsi }}</td>
								<td class="px-4 py-3 text-sm">
									<div class="flex flex-wrap items-center gap-2">
										<a href="{{ route('kategori.edit', $item) }}"
											class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
											<i class="fas fa-pen" aria-hidden="true"></i>
											Edit
										</a>
										<form action="{{ route('kategori.hapus', $item) }}" method="POST" class="inline"
											onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
											@csrf
											@method('DELETE')
											<button type="submit"
												class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
												<i class="fas fa-trash" aria-hidden="true"></i>
												Hapus
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="px-4 py-10 text-center">
									<p class="font-medium text-gray-800">Belum ada kategori</p>
									<p class="mt-1 text-sm text-gray-500">Tambahkan kategori untuk mulai mengelola data.</p>
									<a href="{{ route('kategori.tambah') }}"
										class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
										<i class="fas fa-plus" aria-hidden="true"></i>
										Tambah Kategori
									</a>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
>>>>>>> 62312ce (Perbaikan kategori)
