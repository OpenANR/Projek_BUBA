<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Materi - {{ $materi->nama_materi }} - BUBA</title>
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
                <li><a href="{{ route('materi.add') }}">+ Tambah Materi</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">📄 Detail Materi Pembelajaran</h1>
                <p class="page-subtitle">Informasi lengkap mengenai konten dan kategori materi</p>
            </div>
            <div>
                <a href="{{ route('index.materi') }}" class="btn btn-secondary">
                    &larr; Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">{{ $materi->nama_materi }}</h2>
                </div>
                <div>
                    <span class="badge badge-kategori">
                        {{ $materi->kategori ? $materi->kategori->nama_kategori : 'Tanpa Kategori' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="detail-box">
                    <!-- Judul Materi -->
                    <div class="detail-row">
                        <span class="detail-label">Nama Materi</span>
                        <span class="detail-value" style="font-weight: 600; font-size: 1.15rem;">
                            {{ $materi->nama_materi }}
                        </span>
                    </div>

                    <!-- Kategori -->
                    <div class="detail-row">
                        <span class="detail-label">Kategori</span>
                        <span class="detail-value">
                            {{ $materi->kategori ? $materi->kategori->nama_kategori : '-' }}
                        </span>
                    </div>

                    <!-- Tanggal Dibuat -->
                    <div class="detail-row">
                        <span class="detail-label">Waktu Dibuat / Terakhir Diperbarui</span>
                        <span class="detail-value" style="color: var(--text-secondary); font-size: 0.9rem;">
                            Dibuat: {{ $materi->created_at ? $materi->created_at->translatedFormat('d F Y, H:i') : '-' }} &bull; 
                            Diperbarui: {{ $materi->updated_at ? $materi->updated_at->translatedFormat('d F Y, H:i') : '-' }}
                        </span>
                    </div>

                    <!-- Gambar Pendukung -->
                    @if ($materi->gambar)
                        <div class="detail-row">
                            <span class="detail-label">Gambar Pendukung</span>
                            <div class="detail-img-wrapper">
                                <img src="{{ asset('storage/' . $materi->gambar) }}" alt="{{ $materi->nama_materi }}">
                            </div>
                        </div>
                    @endif

                    <!-- Konten Isi Materi -->
                    <div class="detail-row">
                        <span class="detail-label">Konten / Isi Materi</span>
                        <div class="detail-content-box">{{ $materi->isi_materi }}</div>
                    </div>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="card-footer">
                <a href="{{ route('materi.edit', $materi->id) }}" class="btn btn-warning">
                    ✏️ Edit Materi
                </a>
                <form action="{{ route('materi.delete', $materi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Hapus Materi
                    </button>
                </form>
                <a href="{{ route('index.materi') }}" class="btn btn-secondary">
                    Tutup
                </a>
            </div>
        </div>
    </div>
</body>

</html>