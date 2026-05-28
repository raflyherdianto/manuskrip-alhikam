<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuskrip Menunggu Verifikasi</title>
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
            background: linear-gradient(135deg, #1F304B 0%, #2c4a73 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.9;
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
        .karya-info {
            background-color: #f8f9fa;
            border-left: 4px solid #1F304B;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .karya-info h3 {
            margin: 0 0 15px 0;
            color: #1F304B;
            font-size: 16px;
            font-weight: 600;
        }
        .info-row {
            margin: 10px 0;
            font-size: 14px;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            display: inline-block;
            width: 120px;
        }
        .info-value {
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #ffc107;
            color: #000;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 5px;
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
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
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
            <h1>📚 Manuskrip Digital Pesantren</h1>
            <p>Pesantren Mahasiswa Al-Hikam Malang</p>
        </div>

        <div class="content">
            <div class="greeting">
                Halo, {{ $userName }}!
            </div>

            <div class="message">
                Terima kasih telah mengunggah manuskrip Anda ke sistem repository. Manuskrip Anda telah berhasil diterima dan saat ini sedang dalam proses verifikasi oleh admin.
            </div>

            <div class="karya-info">
                <h3>📄 Informasi Manuskrip</h3>
                <div class="info-row">
                    <span class="info-label">Judul:</span>
                    <span class="info-value">{{ $karyaTitle }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Manuskrip:</span>
                    <span class="info-value">{{ $jenisKarya }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori:</span>
                    <span class="info-value">{{ $kategori }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Upload:</span>
                    <span class="info-value">{{ $uploadDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="status-badge">⏳ Menunggu Verifikasi</span>
                </div>
            </div>

            <div class="info-box">
                <p><strong>ℹ️ Apa yang terjadi selanjutnya?</strong></p>
                <p>• Tim admin akan meninjau manuskrip Anda dalam 1-3 hari kerja</p>
                <p>• Anda akan menerima notifikasi melalui email dan sistem</p>
                <p>• Anda dapat memantau status manuskrip di menu "Aktivitas"</p>
            </div>

            <div class="button-container">
                <a href="{{ $activityUrl }}" class="button">
                    Lihat Status Manuskrip
                </a>
            </div>

            <div class="divider"></div>

            <div class="message" style="font-size: 14px; color: #666;">
                <p><strong>Catatan:</strong></p>
                <p>Jika Anda tidak melakukan upload manuskrip ini, silakan hubungi admin segera.</p>
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
