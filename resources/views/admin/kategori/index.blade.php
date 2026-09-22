<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
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
</html>