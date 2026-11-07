<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    @include('layouts.partials.favicon')

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin-bottom: 5px;
            color: #2563eb;
        }

        .header p {
            margin: 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #2563eb;
            color: white;
            padding: 9px 6px;
            border: 1px solid #ddd;
        }

        td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        td.nama {
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f3f6fb;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>BUBA - Laporan Hasil Reward</h2>
        <p>{{ $judul }}</p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th>Benar</th>
                <th>Salah</th>
                <th>Nilai</th>
                <th>Bintang</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rewards as $reward)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="nama">
                        {{ $reward->user->name ?? 'Anak tidak ditemukan' }}
                    </td>

                    <td>
                        {{ $reward->quis->kelas->nama_kelas ?? '-' }}
                    </td>

                    <td>
                        {{ $reward->quis->kategori->nama_kategori ?? '-' }}
                    </td>

                    <td>{{ $reward->jumlah_benar }}</td>

                    <td>{{ $reward->jumlah_salah }}</td>

                    <td>{{ $reward->skor }}</td>

                    <td>
                        {{ $reward->jumlah_bintang }} ⭐
                    </td>

                    <td>
                        {{ $reward->created_at?->format('d-m-Y H:i') ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Belum ada data reward.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh sistem BUBA.
    </div>

</body>
</html>
