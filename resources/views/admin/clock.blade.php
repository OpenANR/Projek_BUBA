<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Digital Laravel 12</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .clock-card {
            background: #1e293b;
            padding: 30px 50px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            text-align: center;
            border: 1px solid #334155;
        }

        .date-display {
            font-size: 1.25rem;
            color: #94a3b8;
            margin-bottom: 10px;
            text-transform: capitalize;
        }

        .time-display {
            font-size: 3.5rem;
            font-weight: bold;
            color: #38bdf8;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>
<body>

    <div class="clock-card">
        <!-- Area Tanggal (Hari, Tanggal Bulan Tahun) -->
        <div id="date-display" class="date-display">--</div>
        <!-- Area Jam Digital (HH:MM:SS) -->
        <div id="time-display" class="time-display">00:00:00</div>
    </div>

    <script>
        // Tampilkan waktu WIB (Asia/Jakarta) apa pun timezone perangkat pengguna.
        const wibDateFormatter = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric',
        });

        const wibTimeFormatter = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });

        function updateClock() {
            const now = new Date();

            document.getElementById('date-display').textContent = wibDateFormatter.format(now);
            document.getElementById('time-display').textContent = wibTimeFormatter.format(now);
        }

        // Jalankan fungsi saat halaman dimuat
        updateClock();

        // Perbarui jam setiap 1000 milidetik (1 detik)
        setInterval(updateClock, 1000);
    </script>
</body>
</html>