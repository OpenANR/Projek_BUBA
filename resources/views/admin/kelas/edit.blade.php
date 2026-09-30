@extends('layouts.admin.app')
@section('title', 'Edit Kelas - BUBA')

@section('content')
	<div class="max-w-3xl mx-auto">
		<div class="bg-white rounded-xl shadow-md overflow-hidden">
			<div class="bg-linear-to-r from-yellow-500 to-orange-500 px-6 py-5">
				<h1 class="text-2xl font-bold text-white">Edit Kelas</h1>
				<p class="text-yellow-100 text-sm mt-1">Perbarui informasi {{ $kelas->nama_kelas }}</p>
			</div>

			<div class="p-6">
				@if ($errors->any())
					<div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
						<p class="font-semibold mb-1">Terjadi kesalahan:</p>
						<ul class="list-disc list-inside text-sm space-y-1">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="{{ route('kelas.update', $kelas) }}" method="POST" class="space-y-5">
					@csrf
					@method('PUT')
					<div>
						<label for="nama_kelas" class="block text-sm font-semibold text-gray-700 mb-1">
							Nama Kelas <span class="text-red-500">*</span>
						</label>
						<input type="text" name="nama_kelas" id="nama_kelas"
							value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required maxlength="10"
							class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
					</div>

					<div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
						<a href="{{ route('kelas.index') }}"
							class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
							Batal
						</a>
						<button type="submit"
							class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
							<i class="fas fa-rotate" aria-hidden="true"></i>
							Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const input = document.getElementById('nama_kelas');
			const button = input.form.querySelector('button[type="submit"]');

			function updateButtonState() {
				const cursorPosition = input.selectionStart;
				const sanitizedValue = input.value.replace(/[^A-Za-z0-9-]/g, '');

				if (sanitizedValue !== input.value) {
					const sanitizedCursorPosition = input.value.slice(0, cursorPosition).replace(/[^A-Za-z0-9-]/g, '').length;
					input.value = sanitizedValue;
					input.setSelectionRange(sanitizedCursorPosition, sanitizedCursorPosition);
				}

				const isValid = input.value.length > 0
					&& input.value.length <= 10
					&& /^[A-Za-z0-9-]+$/.test(input.value);

				button.disabled = !isValid;
				button.classList.toggle('bg-yellow-500', isValid);
				button.classList.toggle('hover:bg-yellow-600', isValid);
				button.classList.toggle('bg-gray-400', !isValid);
				button.classList.toggle('hover:bg-gray-400', !isValid);
				button.classList.toggle('cursor-not-allowed', !isValid);
			}

			input.addEventListener('input', updateButtonState);
			updateButtonState();
		});
	</script>
@endpush