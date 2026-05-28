<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Berhasil Diverifikasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.95;
        }
        .content {
            padding: 30px 25px;
        }
        .greeting {
            font-size: 18px;
            color: #1F304B;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        .verification-box {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
            text-align: center;
        }
        .verification-box h3 {
            margin: 0 0 10px 0;
            color: #2e7d32;
            font-size: 20px;
            font-weight: 600;
        }
        .verification-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #1b5e20;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background-color: #28a745;
            color: #fff;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }
        .info-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
            font-weight: 600;
        }
        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
            color: #856404;
        }
        .info-box li {
            margin: 8px 0;
            font-size: 14px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #1F304B 0%, #2c4a73 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 15px;
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .credentials-box h4 {
            margin: 0 0 15px 0;
            color: #1F304B;
            font-size: 16px;
            font-weight: 600;
        }
        .credential-row {
            margin: 10px 0;
            font-size: 14px;
        }
        .credential-label {
            font-weight: 600;
            color: #666;
            display: inline-block;
            width: 100px;
        }
        .credential-value {
            color: #333;
            font-family: 'Courier New', monospace;
            background-color: #fff;
            padding: 2px 8px;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #1F304B;
            text-decoration: none;
            font-weight: 600;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">✅</div>
            <h1>Akun Berhasil Diverifikasi!</h1>
            <p>Manuskrip Digital Pesantren - Pesantren Mahasiswa Al-Hikam Malang</p>
        </div>

        <div class="content">
            <div class="greeting">
                Selamat, {{ $userName }}!
            </div>

            <div class="message">
                Akun Anda telah <strong>berhasil diverifikasi</strong> dan sekarang sudah aktif. Anda sudah dapat mengakses semua fitur sistem repository manuskrip dengan lengkap.
            </div>

            <div class="verification-box">
                <h3>🎉 Verifikasi Berhasil!</h3>
                <p>Status akun Anda telah diperbarui</p>
                <span class="status-badge">✓ Akun Terverifikasi</span>
            </div>

            <div class="credentials-box">
                <h4>🔐 Informasi Login Anda</h4>
                <div class="credential-row">
                    <span class="credential-label">Email:</span>
                    <span class="credential-value">{{ $userEmail }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $passwordChanged ? '•••••••• (Baru diubah)' : 'Tidak berubah' }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Status:</span>
                    <span class="credential-value" style="color: #28a745; font-weight: 600;">Verified ✓</span>
                </div>
            </div>

            <div class="info-box">
                <h4>📋 Apa yang bisa Anda lakukan sekarang?</h4>
                <ul>
                    <li>Mengunggah manuskrip akademik Anda</li>
                    <li>Mengelola semua manuskrip yang telah diunggah</li>
                    <li>Memantau status verifikasi manuskrip</li>
                    <li>Mengakses statistik dan riwayat aktivitas</li>
                    <li>Mengunduh dan berbagi manuskrip yang dipublikasikan</li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{{ $activityUrl }}" class="button">
                    🚀 Mulai Mengunggah Manuskrip
                </a>
            </div>

            <div class="divider"></div>

            <div class="message" style="font-size: 14px; color: #666;">
                <p><strong>⚠️ Penting untuk Keamanan:</strong></p>
                <p>• Jangan bagikan password Anda kepada siapapun</p>
                <p>• Gunakan password yang kuat dan unik</p>
                <p>• Logout setelah selesai menggunakan sistem di komputer publik</p>
                <p>• Jika ada aktivitas mencurigakan, segera hubungi admin</p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Manuskrip Digital Pesantren</strong></p>
            <p>Pesantren Mahasiswa Al-Hikam Malang</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>Butuh bantuan? <a href="mailto:alhikam@gmail.com">Hubungi Admin</a></p>
        </div>
    </div>
</body>
</html>
