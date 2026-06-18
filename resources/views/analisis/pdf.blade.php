<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume Medis AI — The Ethereal Clinic</title>
    <style>
        /* Base Reset untuk DOMPDF */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333333; line-height: 1.4; padding: 30px; }
        
        /* Kop Surat Fasyankes */
        .kop-surat { width: 100%; border-bottom: 3px solid #7B5556; padding-bottom: 15px; margin-bottom: 20px; }
        .kop-table { width: 100%; }
        .kop-logo { width: 70px; height: 70px; background-color: #7B5556; color: white; text-align: center; font-size: 32px; font-weight: bold; line-height: 70px; border-radius: 8px; }
        .kop-text { padding-left: 15px; vertical-align: top; }
        .kop-title { font-size: 22px; font-weight: bold; color: #7B5556; margin-bottom: 3px; letter-spacing: 1px; }
        .kop-subtitle { font-size: 10px; color: #5D605C; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 5px; }
        .kop-address { font-size: 10px; color: #666; line-height: 1.5; }
        
        /* Judul Dokumen */
        .document-title { text-align: center; font-size: 14px; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-bottom: 2px; color: #333; }
        .document-rm { text-align: center; font-size: 10px; color: #666; margin-bottom: 20px; }

        /* Tabel Demografi Pasien */
        .demografi-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #333; }
        .demografi-table td { padding: 6px 10px; font-size: 11px; border: 1px solid #333; }
        .bg-gray { background-color: #F0F0F0; font-weight: bold; width: 20%; }
        .value-cell { width: 30%; }

        /* Section Headers */
        .section-title { font-size: 11px; font-weight: bold; color: #7B5556; border-bottom: 1px solid #7B5556; padding-bottom: 3px; margin-bottom: 10px; margin-top: 15px; text-transform: uppercase; }

        /* Tabel Data / Hasil */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .data-table th { background-color: #7B5556; color: white; padding: 8px; font-size: 10px; text-align: left; border: 1px solid #7B5556; }
        .data-table td { padding: 7px 8px; font-size: 10px; border: 1px solid #ddd; vertical-align: top; }
        .data-table tr:nth-child(even) td { background-color: #FAFAFA; }

        /* Highlight Diagnosis */
        .diagnosis-box { background-color: #EBDBDD; border-left: 4px solid #7B5556; padding: 12px; margin-bottom: 15px; }
        .diagnosis-title { font-size: 10px; color: #5D605C; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .diagnosis-result { font-size: 16px; font-weight: bold; color: #7B5556; }
        .cf-score { font-size: 12px; font-weight: bold; color: #333; background: #fff; padding: 2px 6px; border-radius: 4px; display: inline-block; border: 1px solid #7B5556; margin-left: 10px;}

        /* Footer */
        .footer { position: fixed; bottom: -10px; left: 30px; right: 30px; font-size: 8px; color: #888; border-top: 1px solid #ddd; padding-top: 5px; text-align: justify; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">E</td>
                <td class="kop-text">
                    <div class="kop-title">THE ETHEREAL CLINIC</div>
                    <div class="kop-subtitle">Pusat Spesialis Dermatologi & Kecantikan Kulit</div>
                    <div class="kop-address">
                        Gedung Ethereal Lt. 3, Jl. Veteran No. 12, Malang, Jawa Timur 65111<br>
                        Telp: (0341) 555-0100 | WhatsApp: 0812-3456-7890 | Email: care@etherealclinic.id<br>
                        <em>Izin Operasional Klinik Utama No: 442/123/IX/2025</em>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="document-title">RESUME MEDIS & SKRINING KLINIS AWAL</div>
    <div class="document-rm">Nomor RM / Ref: <strong>#RM-{{ str_pad($history->id ?? rand(100,999), 5, '0', STR_PAD_LEFT) }}</strong></div>

    <table class="demografi-table">
        <tr>
            <td class="bg-gray">Nama Lengkap</td>
            <td class="value-cell" colspan="3"><strong>{{ $user->name ?? 'Pasien' }}</strong></td>
        </tr>
        <tr>
            <td class="bg-gray">Email/Kontak</td>
            <td class="value-cell">{{ $user->email ?? '-' }}</td>
            <td class="bg-gray">Waktu Skrining</td>
            <td class="value-cell">{{ $tanggal }} WIB</td>
        </tr>
        <tr>
            <td class="bg-gray">Jenis Skrining</td>
            <td class="value-cell">CDSS - Custom YOLOv8 Object Detection via Roboflow API</td>
            <td class="bg-gray">Metode Inferensi</td>
            <td class="value-cell">Certainty Factor (CF)</td>
        </tr>
    </table>

    <div class="section-title">I. Assessment (Hasil Diagnosis Sistem)</div>
    <div class="diagnosis-box">
        <div class="diagnosis-title">Kesimpulan Identifikasi Masalah Kulit Dominan:</div>
        <div class="diagnosis-result">
            {{ $kondisi_label ?? 'Acne Vulgaris' }}
            <span class="cf-score">Tingkat Kepastian (CF): {{ round(($cf_final ?? 0.85) * 100, 1) }}%</span>
        </div>
    </div>

    <div class="section-title">II. Objective (Temuan Visual AI Bounding Box)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Objek Visual Terdeteksi</th>
                <th width="20%">Jumlah Lesi</th>
                <th width="20%">Tingkat Keparahan</th>
                <th width="20%">Akurasi Pemindaian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($temuan_klinis as $i => $item)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td><strong>{{ $item['nama_objek'] }}</strong></td>
                <td style="text-align: center;">{{ $item['jumlah'] }} Titik</td>
                <td style="text-align: center; font-weight: bold;">{{ $item['tingkat_keparahan'] }}</td>
                <td style="text-align: center;">{{ round($item['avg_confidence'] * 100) }}%</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; font-style: italic;">Tidak ada anomali visual yang terdeteksi dengan tingkat keyakinan yang mencukupi.</td></tr>
            @endforelse
        </tbody>
    </table>

<div class="section-title">III. Plan (Rekomendasi Penatalaksanaan Klinis)</div>
    
    <div style="font-size: 10px; font-weight: bold; color: #5D605C; margin-bottom: 5px; text-transform: uppercase;">A. Rekomendasi Skincare & Obat</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Produk</th>
                <th width="60%">Kandungan / Indikasi</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($recProducts) && count($recProducts) > 0)
                @foreach($recProducts as $idx => $product)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $product['nama_produk'] ?? '-' }}</strong></td>
                    <td style="text-align: justify;">{{ $product['kandungan'] ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" style="text-align: center; font-style: italic; color: #888;">Tidak ada rekomendasi produk spesifik untuk kondisi ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="font-size: 10px; font-weight: bold; color: #5D605C; margin-bottom: 5px; margin-top: 15px; text-transform: uppercase;">B. Rekomendasi Tindakan Klinik</div>
    <table class="data-table" style="margin-bottom: 5px;">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Treatment</th>
                <th width="60%">Deskripsi Prosedur</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($recTreatments) && count($recTreatments) > 0)
                @foreach($recTreatments as $idx => $treatment)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $treatment['nama_treatment'] ?? '-' }}</strong></td>
                    <td style="text-align: justify;">{{ $treatment['deskripsi'] ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" style="text-align: center; font-style: italic; color: #888;">Tidak ada rekomendasi tindakan klinik spesifik untuk kondisi ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="font-size: 9px; color: #8B3A3A; font-style: italic; margin-bottom: 20px; margin-top: 5px;">
        *Rekomendasi di atas dihasilkan secara otomatis oleh basis pengetahuan pakar (Knowledge Base) sistem berdasarkan hasil kalkulasi diagnosis dominan.
    </div>

</body>
</html>