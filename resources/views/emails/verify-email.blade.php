<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Konfirmasi Alamat Email - BUBA</title>
    <!--[if mso]>
    <style type="text/css">
        table {border-collapse:collapse;border-spacing:0;margin:0;}
        div, td {padding:0;}
        div {margin:0 !important;}
        body, table, td, p, a, li, blockquote {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@500;600;700;800;900&display=swap');
        
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            background-color: #eaf4fe;
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        a {
            color: #1e60be;
            text-decoration: none;
        }
        .btn-hover:hover {
            background-color: #52a432 !important;
        }
        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
            .card-body {
                padding: 24px 18px !important;
            }
            .feature-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 10px !important;
            }
            .btn-action {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
                text-align: center !important;
                padding: 16px 20px !important;
            }
            .header-logo {
                width: 140px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #eaf4fe; font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    @php
        $logoSrc = null;
        try {
            if (isset($message) && is_object($message) && method_exists($message, 'embed') && file_exists(public_path('images/logoBuba.png'))) {
                $logoSrc = $message->embed(public_path('images/logoBuba.png'));
            }
        } catch (\Throwable $e) {
            $logoSrc = null;
        }

        if (!$logoSrc) {
            $logoSrc = url('images/logoBuba.png');
        }

        $userName = !empty($user->name) ? $user->name : 'Teman Pintar';
    @endphp

    <!-- Wrapper Tabel Penuh -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#eaf4fe" style="background-color: #eaf4fe; min-height: 100vh;">
        <tr>
            <td align="center" style="padding: 30px 15px 40px 15px;">

                <!-- Container Utama Email (Maks 580px) -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" style="max-width: 580px; margin: 0 auto;">
                    
                    <!-- ==============================================
                         BAGIAN 1: HEADER & LOGO APLIKASI BUBA
                         ============================================== -->
                    <tr>
                        <td align="center" style="padding-bottom: 22px;">
                            <a href="{{ url('/') }}" target="_blank" style="text-decoration: none; display: inline-block;">
                                <img src="{{ $logoSrc }}" 
                                     alt="Logo BUBA - Belajar, Bermain, Berkembang" 
                                     width="170" 
                                     class="header-logo" 
                                     style="display: block; width: 170px; max-width: 100%; height: auto; margin: 0 auto;" />
                            </a>
                        </td>
                    </tr>

                    <!-- ==============================================
                         BAGIAN 2: KARTU KONTEN UTAMA (BUBA THEME)
                         ============================================== -->
                    <tr>
                        <td>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 3px solid #d7e8fa; border-radius: 28px; box-shadow: 0 16px 36px rgba(30, 96, 190, 0.12); overflow: hidden;">
                                
                                <!-- Pita Aksen Atas Kartu -->
                                <tr>
                                    <td height="8" style="background-color: #1e60be; line-height: 8px; font-size: 8px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="card-body" style="padding: 32px 34px 34px 34px; text-align: center;">

                                        <!-- Badge Melayang Khas BUBA -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto 18px auto;">
                                            <tr>
                                                <td align="center" bgcolor="#1e60be" style="background-color: #1e60be; border: 3px solid #ffffff; border-radius: 50px; padding: 7px 24px; box-shadow: 0 6px 14px rgba(30, 96, 190, 0.25);">
                                                    <span style="font-family: 'Figtree', Arial, sans-serif; font-size: 13px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: 1.2px; display: inline-block;">
                                                        ✉️ &nbsp;KONFIRMASI EMAIL
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Judul Sapaan Hangat -->
                                        <h1 style="margin: 0 0 6px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 24px; font-weight: 900; color: #0f172a; line-height: 1.3;">
                                            Halo, {{ $userName }}! 👋
                                        </h1>
                                        
                                        <!-- Subjudul -->
                                        <p style="margin: 0 0 20px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 14px; font-weight: 700; color: #64748b;">
                                            Satu langkah lagi untuk mulai belajar &amp; bermain seru di BUBA!
                                        </p>

                                        <!-- Deskripsi Utama -->
                                        <p style="margin: 0 0 24px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 15px; font-weight: 500; color: #334155; line-height: 1.65; text-align: center;">
                                            Terima kasih sudah bergabung di <strong>BUBA (Belajar, Bermain, Berkembang)</strong>! 🎉<br/>
                                            Untuk memastikan alamat email kamu aktif dan menjaga keamanan akunmu, silakan klik tombol hijau di bawah ini untuk konfirmasi:
                                        </p>

                                        <!-- ==============================================
                                             TOMBOL CTA 3D BUBA (HIJAU CERIA)
                                             ============================================== -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 10px auto 26px auto;">
                                            <tr>
                                                <td align="center" bgcolor="#5db139" style="border-radius: 50px; background-color: #5db139; border-bottom: 4px solid #3b841c; box-shadow: 0 8px 18px rgba(93, 177, 57, 0.35);">
                                                    <a href="{{ $url }}" 
                                                       target="_blank" 
                                                       class="btn-action btn-hover"
                                                       style="display: inline-block; font-family: 'Figtree', Arial, sans-serif; font-size: 15px; font-weight: 900; color: #ffffff; text-decoration: none; padding: 15px 36px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.8px;">
                                                        VERIFIKASI EMAIL SEKARANG &nbsp;➜
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ==============================================
                                             KARTU FITUR UNGGULAN BUBA (BADGES)
                                             ============================================== -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px 0 24px 0;">
                                            <tr>
                                                <td class="feature-column" width="32%" align="center" valign="top" style="padding: 4px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fffbeb; border: 2px solid #fde68a; border-radius: 16px; padding: 12px 8px;">
                                                        <tr>
                                                            <td align="center">
                                                                <span style="font-size: 20px; display: block; margin-bottom: 4px;">⭐</span>
                                                                <strong style="display: block; font-size: 12px; color: #92400e; font-family: 'Figtree', Arial, sans-serif; font-weight: 800;">Kuis Menarik</strong>
                                                                <span style="font-size: 11px; color: #b45309; font-family: 'Figtree', Arial, sans-serif;">Berhadiah bintang</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="feature-column" width="32%" align="center" valign="top" style="padding: 4px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 16px; padding: 12px 8px;">
                                                        <tr>
                                                            <td align="center">
                                                                <span style="font-size: 20px; display: block; margin-bottom: 4px;">📚</span>
                                                                <strong style="display: block; font-size: 12px; color: #166534; font-family: 'Figtree', Arial, sans-serif; font-weight: 800;">Materi Seru</strong>
                                                                <span style="font-size: 11px; color: #15803d; font-family: 'Figtree', Arial, sans-serif;">Khusus PAUD &amp; TK</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="feature-column" width="32%" align="center" valign="top" style="padding: 4px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fdf2f8; border: 2px solid #fbcfe8; border-radius: 16px; padding: 12px 8px;">
                                                        <tr>
                                                            <td align="center">
                                                                <span style="font-size: 20px; display: block; margin-bottom: 4px;">🎨</span>
                                                                <strong style="display: block; font-size: 12px; color: #9d174d; font-family: 'Figtree', Arial, sans-serif; font-weight: 800;">Bermain Ceria</strong>
                                                                <span style="font-size: 11px; color: #be185d; font-family: 'Figtree', Arial, sans-serif;">Edukasi ramah anak</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ==============================================
                                             KOTAK INFORMASI / KEAMANAN (SOFT SKY BLUE)
                                             ============================================== -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0f7ff; border: 2px solid #bae6fd; border-radius: 16px; margin-bottom: 22px;">
                                            <tr>
                                                <td style="padding: 14px 18px; text-align: left;">
                                                    <p style="margin: 0; font-family: 'Figtree', Arial, sans-serif; font-size: 12.5px; line-height: 1.6; color: #0369a1;">
                                                        ⏱️ <strong>Catatan Penting:</strong> Tautan verifikasi ini berlaku selama <strong>60 menit</strong>. Jika kamu tidak merasa membuat akun di BUBA, silakan abaikan email ini dan akun tidak akan diaktifkan.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Salam Penutup -->
                                        <p style="margin: 0 0 24px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 14px; font-weight: 600; color: #475569; line-height: 1.6; text-align: center;">
                                            Salam hangat &amp; penuh semangat,<br />
                                            <strong style="color: #1e60be; font-size: 15px;">Tim BUBA (Belajar, Bermain, Berkembang)</strong>
                                        </p>

                                        <!-- Divider Pemisah Halus -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 18px;">
                                            <tr>
                                                <td style="border-top: 1px dashed #cbd5e1; height: 1px; font-size: 1px; line-height: 1px;">&nbsp;</td>
                                            </tr>
                                        </table>

                                        <!-- ==============================================
                                             TROUBLESHOOTING FALLBACK URL
                                             ============================================== -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="text-align: left;">
                                                    <p style="margin: 0 0 8px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 11.5px; font-weight: 600; color: #64748b; line-height: 1.5;">
                                                        Mengalami kendala saat mengeklik tombol "Verifikasi Email Sekarang"? Salin dan tempel alamat tautan di bawah ini ke peramban (browser) web kamu:
                                                    </p>
                                                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; word-break: break-all; font-family: Consolas, Monaco, monospace; font-size: 11px; line-height: 1.5; color: #2563eb;">
                                                        <a href="{{ $url }}" target="_blank" style="color: #2563eb; text-decoration: underline; word-break: break-all;">
                                                            {{ $url }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ==============================================
                         BAGIAN 3: FOOTER EMAIL
                         ============================================== -->
                    <tr>
                        <td align="center" style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0 0 4px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 12px; font-weight: 800; color: #1e60be;">
                                ✨ Belajar Lebih Seru, Bermain Lebih Pintar ✨
                            </p>
                            <p style="margin: 0 0 6px 0; font-family: 'Figtree', Arial, sans-serif; font-size: 11.5px; font-weight: 600; color: #64748b;">
                                BUBA E-Learning Application
                            </p>
                            <p style="margin: 0; font-family: 'Figtree', Arial, sans-serif; font-size: 11px; font-weight: 600; color: #94a3b8;">
                                &copy; {{ date('Y') }} NAJATIF. All Right Reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
