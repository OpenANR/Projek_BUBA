<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Materi - BUBA</title>
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
                <li><a href="{{ route('index.materi') }}" class="active">Data Materi</a></li>
                <li><a href="{{ route('materi.add') }}">+ Tambah Materi</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">📚 Daftar Materi Pembelajaran</h1>
                <p class="page-subtitle">Kelola dan atur seluruh materi pembelajaran aplikasi BUBA</p>
            </div>
            <div>
                <a href="{{ route('materi.add') }}" class="btn btn-primary">
                    <span>+</span> Tambah Materi Baru
                </a>
            </div>
        </div>

        <!-- Notification Alert -->
        @if (session('succes'))
            <div class="alert alert-success">
                <span>✓</span>
                <span>{{ session('succes') }}</span>
            </div>
        @endif

        <!-- Card & Data Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Tabel Materi ({{ $materi->count() }})</h2>
            </div>
            <div class="table-responsive">
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th class="th-center" style="width: 50px;">No</th>
                            <th>Nama Materi</th>
                            <th>Kategori</th>
                            <th class="th-center" style="width: 80px;">Gambar</th>
                            <th>Isi Materi</th>
                            <th class="th-center" style="width: 190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materi as $item)
                            <tr>
                                <td class="td-center">{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->nama_materi }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-kategori">
                                        {{ $item->kategori ? $item->kategori->nama_kategori : 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="td-center">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_materi }}" class="thumbnail-box">
                                    @else
                                        <div class="no-image">No Image</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="materi-preview-text" title="{{ $item->isi_materi }}">
                                        {{ Str::limit($item->isi_materi, 80) }}
                                    </div>
                                </td>
                                <td class="td-center td-nowrap">
                                    <div class="action-buttons">
                                        <a href="{{ route('materi.detail_materi', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            Detail
                                        </a>
                                        <a href="{{ route('materi.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit Materi">
                                            Edit
                                        </a>
                                        <form action="{{ route('materi.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Materi">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📖</div>
                                        <h3 class="empty-state-title">Belum ada materi pembelajaran</h3>
                                        <p class="empty-state-text">Silakan tambahkan materi baru untuk mulai mengisi pembelajaran.</p>
                                        <a href="{{ route('materi.add') }}" class="btn btn-primary">
                                            + Tambah Materi Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
