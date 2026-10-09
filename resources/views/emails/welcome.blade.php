<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akun Berhasil Dibuat</title>
</head>
<body style="margin:0; padding:0; background:#F3F5F9; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F3F5F9; padding:32px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border-radius:12px; overflow:hidden; max-width:480px; width:100%;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0D1B36; padding:28px 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:36px; height:36px; background:#2C5CE0; border-radius:8px; text-align:center; vertical-align:middle; color:#ffffff; font-size:12px; font-weight:bold;">
                                        IT
                                    </td>
                                    <td style="padding-left:10px; color:#ffffff; font-size:15px; font-weight:bold;">
                                        Helpdesk IT Cibeureum
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">

                            <h1 style="margin:0 0 12px; font-size:20px; color:#172033;">
                                Selamat datang, {{ $user->name }}!
                            </h1>

                            <p style="margin:0 0 16px; font-size:14px; line-height:1.6; color:#4B5568;">
                                Akun Anda di <strong>Sistem Pengaduan Barang Rusak &mdash; Kelurahan Cibeureum</strong>
                                sudah berhasil dibuat dengan detail berikut:
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F3F5F9; border-radius:8px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:14px 18px; font-size:13px; color:#8891A3;">Nama</td>
                                    <td style="padding:14px 18px; font-size:13px; color:#172033; font-weight:bold; text-align:right;">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 18px 14px; font-size:13px; color:#8891A3;">Email</td>
                                    <td style="padding:0 18px 14px; font-size:13px; color:#172033; font-weight:bold; text-align:right;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 18px 14px; font-size:13px; color:#8891A3;">Role</td>
                                    <td style="padding:0 18px 14px; font-size:13px; color:#172033; font-weight:bold; text-align:right;">Staf</td>
                                </tr>
                            </table>

                            <p style="margin:0 0 24px; font-size:14px; line-height:1.6; color:#4B5568;">
                                Silakan login memakai email dan password yang tadi Anda daftarkan
                                untuk mulai membuat laporan kerusakan perangkat.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:#2C5CE0; border-radius:8px;">
                                        <a href="{{ route('login') }}"
                                           style="display:inline-block; padding:12px 24px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none;">
                                            Login Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 32px; border-top:1px solid #E2E6EE;">
                            <p style="margin:0; font-size:12px; color:#8891A3;">
                                Email ini dikirim otomatis karena ada pendaftaran akun baru
                                menggunakan alamat email Anda. Kalau ini bukan Anda, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>