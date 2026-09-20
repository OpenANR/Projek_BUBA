<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Materi - BUBA</title>
    <!-- Vanilla CSS Materi CRUD -->
    <link rel="stylesheet" href="{{ asset('css/materi.css') }}">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('index.materi') }}" class="navbar-brand">
                BUBA <span>&bull; Materi</span>
            </a>
            <ul class="navbar-nav">
                <li><a href="{{ route('index.materi') }}">Data Materi</a></li>
                <li><a href="{{ route('materi.add') }}" class="active">+ Tambah Materi</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">📝 Tambah Materi Baru</h1>
                <p class="page-subtitle">Isi formulir di bawah ini untuk menambahkan materi pembelajaran baru ke sistem</p>
            </div>
            <div>
                <a href="{{ route('index.materi') }}" class="btn btn-secondary">
                    &larr; Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Validation Errors Alert -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <div>
                    <strong>Terjadi Kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Formulir Materi Pembelajaran</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="crud-form">
                    @csrf

                    <!-- Nama Materi -->
                    <div class="form-group">
                        <label for="nama_materi" class="form-label">
                            Nama Materi <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_materi" 
                            id="nama_materi" 
                            class="form-control" 
                            placeholder="Masukkan judul atau nama materi..."
                            value="{{ old('nama_materi') }}" 
                            required
                        >
                    </div>

                    <!-- Kategori Materi -->
                    <div class="form-group">
                        <label for="kategori_id" class="form-label">
                            Kategori Materi <span class="required">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="form-group">
                        <label for="gambar" class="form-label">
                            Gambar Pendukung (Opsional)
                        </label>
                        <input 
                            type="file" 
                            name="gambar" 
                            id="gambar" 
                            class="form-control form-file-input" 
                            accept="image/png, image/jpeg, image/jpg"
                        >
                        <span class="form-hint">Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)</span>
                    </div>

                    <!-- Isi Materi -->
                    <div class="form-group">
                        <label for="isi_materi" class="form-label">
                            Isi Materi <span class="required">*</span>
                        </label>
                        <textarea 
                            name="isi_materi" 
                            id="isi_materi" 
                            class="form-textarea" 
                            rows="8" 
                            placeholder="Tuliskan penjelasan materi lengkap di sini..." 
                            required
                        >{{ old('isi_materi') }}</textarea>
                    </div>

                    <!-- Form Actions Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 Simpan Materi
                        </button>
                        <a href="{{ route('index.materi') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
