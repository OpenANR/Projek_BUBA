<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kelola Kelas</title>
	@vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
	<main class="mx-auto w-full max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
		<header class="mb-8 flex flex-col items-center gap-5 text-center sm:flex-row sm:justify-between sm:text-left">
			<div>
				<h1 class="text-3xl font-bold tracking-tight text-gray-900">Kelola Kelas</h1>
				<p class="mt-2 text-sm text-gray-600">Kelola data kelas aplikasi.</p>
			</div>
			<a href="{{ route('kelas.create') }}"
				class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
				<span aria-hidden="true" class="text-lg leading-none">+</span>
				Tambah Kelas
			</a>
		</header>

		@if (session('success'))
			<div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
				{{ session('success') }}
			</div>
		@endif

		@if (session('error'))
			<div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
				{{ session('error') }}
			</div>
		@endif

		<section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm" aria-labelledby="kelas-list-heading">
			<div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
				<h2 id="kelas-list-heading" class="font-semibold text-gray-900">Daftar Kelas</h2>
				<span class="text-sm text-gray-500">{{ $kelas->count() }} kelas</span>
			</div>

			@if ($kelas->isEmpty())
				<div class="px-5 py-14 text-center">
					<h3 class="text-lg font-semibold text-gray-900">Belum ada kelas</h3>
					<p class="mt-1 text-sm text-gray-600">Tambahkan kelas untuk mulai mengelola data.</p>
					<a href="{{ route('kelas.create') }}"
						class="mt-5 inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
						<span aria-hidden="true" class="text-lg leading-none">+</span>
						Tambah Kelas
					</a>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200 text-left">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-5 py-3 text-xs font-semibold uppercase text-gray-600">No</th>
								<th scope="col" class="px-5 py-3 text-xs font-semibold uppercase text-gray-600">Nama Kelas</th>
								<th scope="col" class="px-5 py-3 text-xs font-semibold uppercase text-gray-600">Jumlah Siswa</th>
								<th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-600">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-100">
							@foreach ($kelas as $item)
								<tr class="hover:bg-gray-50">
									<td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
									<td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900">{{ $item->nama_kelas }}</td>
									<td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $item->siswas_count }} siswa</td>
									<td class="whitespace-nowrap px-5 py-4">
										<div class="flex justify-end gap-2">
											<a href="{{ route('kelas.edit', $item) }}"
												class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Edit</a>
											<form action="{{ route('kelas.destroy', $item) }}" method="POST"
												onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
												@csrf
												@method('DELETE')
												<button type="submit"
													class="inline-flex items-center rounded-md border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Hapus</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>
	</main>
</body>
</html>