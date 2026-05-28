<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Manuskrip Diperbarui</title>
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
            @if($status === 'Terpublish')
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            @elseif($status === 'Ditolak')
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            @elseif($status === 'Arsip')
                background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            @else
                background: linear-gradient(135deg, #1F304B 0%, #2c4a73 100%);
            @endif
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
        .status-box {
            @if($status === 'Terpublish')
                background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
                border-left: 4px solid #28a745;
            @elseif($status === 'Ditolak')
                background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
                border-left: 4px solid #dc3545;
            @elseif($status === 'Arsip')
                background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
                border-left: 4px solid #6c757d;
            @else
                background: linear-gradient(135deg, #e7f3ff 0%, #cfe2ff 100%);
                border-left: 4px solid #0d6efd;
            @endif
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .status-box h3 {
            margin: 0 0 15px 0;
            @if($status === 'Terpublish')
                color: #2e7d32;
            @elseif($status === 'Ditolak')
                color: #842029;
            @elseif($status === 'Arsip')
                color: #383d41;
            @else
                color: #1F304B;
            @endif
            font-size: 18px;
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
            padding: 8px 16px;
            @if($status === 'Terpublish')
                background-color: #28a745;
            @elseif($status === 'Ditolak')
                background-color: #dc3545;
            @elseif($status === 'Arsip')
                background-color: #6c757d;
            @else
                background-color: #0d6efd;
            @endif
            color: #fff;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 5px;
        }
        .keterangan-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .keterangan-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
            font-weight: 600;
        }
        .keterangan-box p {
            margin: 5px 0;
            color: #856404;
            font-size: 14px;
            line-height: 1.8;
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
            color: #084298;
        }
        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
            color: #084298;
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
        .karya-info {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .karya-info h4 {
            margin: 0 0 15px 0;
            color: #1F304B;
            font-size: 16px;
            font-weight: 600;
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
            <div class="header-icon">
                @if($status === 'Terpublish')
                    ✅
                @elseif($status === 'Ditolak')
                    ❌
                @elseif($status === 'Arsip')
                    📦
                @else
                    📝
                @endif
            </div>
            <h1>Status Manuskrip Diperbarui</h1>
            <p>Manuskrip Digital Pesantren - Pesantren Mahasiswa Al-Hikam Malang</p>
        </div>

        <div class="content">
            <div class="greeting">
                Halo, {{ $userName }}!
            </div>

            <div class="message">
                @if($status === 'Terpublish')
                    Selamat! Manuskrip Anda telah <strong>disetujui dan dipublikasikan</strong>. Manuskrip Anda sekarang dapat diakses oleh publik di Manuskrip Digital Pesantren.
                @elseif($status === 'Ditolak')
                    Manuskrip Anda telah <strong>ditinjau</strong> dan saat ini <strong>tidak dapat dipublikasikan</strong>. Silakan periksa keterangan di bawah dan lakukan perbaikan yang diperlukan.
                @elseif($status === 'Arsip')
                    Manuskrip Anda telah <strong>diarsipkan</strong>. Manuskrip masih tersimpan dalam sistem tetapi tidak aktif dipublikasikan.
                @else
                    Status manuskrip Anda telah diperbarui oleh admin.
                @endif
            </div>

            <div class="status-box">
                <h3>
                    @if($status === 'Terpublish')
                        🎉 Manuskrip Terpublikasi
                    @elseif($status === 'Ditolak')
                        ⚠️ Manuskrip Ditolak
                    @elseif($status === 'Arsip')
                        📦 Manuskrip Diarsipkan
                    @else
                        📝 Status Diperbarui
                    @endif
                </h3>
                <div class="info-row">
                    <span class="info-label">Status Baru:</span>
                    <span class="status-badge">{{ $status }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Diperbarui:</span>
                    <span class="info-value">{{ $updateDate }}</span>
                </div>
            </div>

            <div class="karya-info">
                <h4>📄 Informasi Manuskrip</h4>
                <div class="info-row">
                    <span class="info-label">Judul:</span>
                    <span class="info-value">{{ $karyaTitle }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis:</span>
                    <span class="info-value">{{ $jenisKarya }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori:</span>
                    <span class="info-value">{{ $kategori }}</span>
                </div>
            </div>

            @if(!empty($keterangan))
            <div class="keterangan-box">
                <h4>💬 Keterangan dari Admin</h4>
                <p>{{ $keterangan }}</p>
            </div>
            @endif

            @if($status === 'Terpublish')
            <div class="info-box">
                <p><strong>✨ Manuskrip Anda Sekarang Publik!</strong></p>
                <p>• Dapat diakses dan diunduh oleh pengguna lain</p>
                <p>• Muncul dalam hasil pencarian</p>
                <p>• Kontribusi Anda telah diakui</p>
            </div>
            @elseif($status === 'Ditolak')
            <div class="info-box">
                <p><strong>🔄 Langkah Selanjutnya:</strong></p>
                <p>• Periksa keterangan dari admin dengan teliti</p>
                <p>• Lakukan perbaikan yang diperlukan</p>
                <p>• Unggah ulang manuskrip setelah diperbaiki</p>
                <p>• Hubungi admin jika ada pertanyaan</p>
            </div>
            @elseif($status === 'Arsip')
            <div class="info-box">
                <p><strong>📋 Tentang Arsip:</strong></p>
                <p>• Manuskrip tidak hilang, masih tersimpan</p>
                <p>• Tidak muncul dalam pencarian publik</p>
                <p>• Dapat diaktifkan kembali oleh admin</p>
                <p>• Hubungi admin untuk informasi lebih lanjut</p>
            </div>
            @endif

            <div class="button-container">
                <a href="{{ $activityUrl }}" class="button">
                    Lihat Manuskrip Saya
                </a>
            </div>

            <div class="divider"></div>

            <div class="message" style="font-size: 14px; color: #666;">
                <p><strong>Catatan:</strong></p>
                <p>Jika Anda memiliki pertanyaan tentang perubahan status ini, silakan hubungi admin melalui sistem atau email resmi.</p>
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
