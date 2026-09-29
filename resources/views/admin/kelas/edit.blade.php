<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Kelas</title>
	@vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
	<main class="mx-auto w-full max-w-3xl px-4 py-10 sm:px-6">
		<a href="{{ route('kelas.index') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-900">&larr; Kembali ke daftar kelas</a>
		<header class="mb-6 mt-5">
			<h1 class="text-2xl font-bold tracking-tight text-gray-900">Edit Kelas</h1>
			<p class="mt-2 text-sm text-gray-600">Perbarui nama kelas {{ $kelas->nama_kelas }}.</p>
		</header>

		<section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
			@if ($errors->any())
				<div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
					<ul class="list-inside list-disc space-y-1">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form action="{{ route('kelas.update', $kelas) }}" method="POST">
				@csrf
				@method('PUT')
				<div>
					<label for="nama_kelas" class="mb-2 block text-sm font-medium text-gray-700">Nama Kelas</label>
					<input id="nama_kelas" name="nama_kelas" type="text" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required maxlength="255"
						class="block w-full rounded-md border border-gray-300 px-3 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20">
				</div>
				<div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-5">
					<a href="{{ route('kelas.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
					<button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Simpan Perubahan</button>
				</div>
			</form>
		</section>
	</main>
</body>
</html>