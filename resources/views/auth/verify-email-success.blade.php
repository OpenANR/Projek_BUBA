<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Berhasil Diverifikasi | BUBA</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f7ff;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .card {
            background: white;
            padding: 40px 30px;
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            max-width: 420px;
            width: 100%;
            text-align: center;
            border: 1.5px solid #bae6fd;
            box-sizing: border-box;
        }
        .icon {
            font-size: 56px;
            margin-bottom: 16px;
        }
        h2 {
            color: #1e60be;
            margin: 0 0 12px 0;
            font-size: 24px;
        }
        .card p {
            color: #475569;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 24px 0;
        }
        .badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0284c7;
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }
        .copyright {
            margin-top: 24px;
            text-align: center;
        }
        .copyright p {
            color: #64748b;
            font-size: 13px;
            margin: 4px 0;
        }
        .copyright .info1 {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🎉</div>
        <h2>Email Berhasil Diverifikasi!</h2>
        <p>Halo <strong>{{ $user->name }}</strong>, akun Anda telah aktif. Silakan buka kembali aplikasi <strong>BUBA</strong> di ponsel Anda untuk mulai belajar.</p>
        <div class="badge">Aplikasi BUBA siap digunakan</div>
    </div>

    <div class="copyright">
        <p class="info1">BUBA E-Learning Application</p>
        <p>&copy; <script>document.write(new Date().getFullYear())</script> NAJATIF. All Rights Reserved.</p>
    </div>
</body>
</html>
