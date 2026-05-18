<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekam Medis AI — The Ethereal Clinic</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #2D2D2D;
            background: #FFFFFF;
            line-height: 1.6;
        }
        /* ── KOP SURAT ────────────────────────────────────── */
        .letterhead {
            width: 100%;
            border-bottom: 3px solid #8B3A3A;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .letterhead-inner {
            display: table;
            width: 100%;
        }
        .letterhead-logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 60px;
        }
        .logo-box {
            width: 52px;
            height: 52px;
            background-color: #8B3A3A;
            border-radius: 10px;
            text-align: center;
            line-height: 52px;
            color: #FFFFFF;
            font-size: 22px;
            font-weight: bold;
        }
        .letterhead-info-cell {
            display: table-cell;
            vertical-align: middle;
            padding-left: 14px;
        }
        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            color: #8B3A3A;
            letter-spacing: 0.5px;
        }
        .clinic-subtitle {
            font-size: 9px;
            color: #797B78;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 1px;
        }
        .clinic-address {
            font-size: 9px;
            color: #A8ABA7;
            margin-top: 4px;
        }
        .letterhead-date-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 9px;
            color: #797B78;
        }
        .doc-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A8ABA7;
            display: block;
            margin-bottom: 2px;
        }
        /* ── SECTION TITLE ────────────────────────────────── */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #8B3A3A;
            border-left: 3px solid #8B3A3A;
            padding-left: 8px;
            margin-bottom: 10px;
            margin-top: 18px;
        }
        /* ── DATA PASIEN TABLE ────────────────────────────── */
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FAF9F6;
            border: 1px solid #E1DDD9;
            border-radius: 6px;
        }
        .patient-table td {
            padding: 7px 12px;
            border-bottom: 1px solid #EDE9E5;
            font-size: 10px;
        }
        .patient-table td:first-child {
            width: 38%;
            color: #797B78;
            font-weight: bold;
        }
        .patient-table td:last-child {
            color: #2D2D2D;
        }
        .patient-table tr:last-child td {
            border-bottom: none;
        }
        /* ── SKOR BOX ─────────────────────────────────────── */
        .score-box {
            display: table;
            width: 100%;
            border: 1px solid #E1DDD9;
            border-radius: 6px;
            margin-bottom: 4px;
        }
        .score-left {
            display: table-cell;
            width: 120px;
            background-color: #8B3A3A;
            border-radius: 6px 0 0 6px;
            text-align: center;
            vertical-align: middle;
            padding: 16px 10px;
        }
        .score-number {
            font-size: 36px;
            font-weight: bold;
            color: #FFFFFF;
            line-height: 1;
        }
        .score-of {
            font-size: 10px;
            color: #EBDBDD;
            display: block;
            margin-top: 2px;
        }
        .score-right {
            display: table-cell;
            vertical-align: middle;
            padding: 14px 18px;
            background-color: #FDF8F7;
        }
        .score-label {
            font-size: 16px;
            font-weight: bold;
            color: #8B3A3A;
            display: block;
            margin-bottom: 4px;
        }
        .score-desc {
            font-size: 10px;
            color: #5D605C;
        }
        .cf-badge {
            display: inline-block;
            background-color: #EBDBDD;
            color: #8B3A3A;
            font-size: 9px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: 6px;
        }
        /* ── TEMUAN TABLE ─────────────────────────────────── */
        .result-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .result-table thead tr {
            background-color: #8B3A3A;
            color: #FFFFFF;
        }
        .result-table thead td {
            padding: 8px 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .result-table thead td:first-child { border-radius: 4px 0 0 0; }
        .result-table thead td:last-child  { border-radius: 0 4px 0 0; }
        .result-table tbody tr:nth-child(even) { background-color: #FAF9F6; }
        .result-table tbody tr:nth-child(odd)  { background-color: #FFFFFF; }
        .result-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #EDE9E5;
            color: #2D2D2D;
        }
        .result-table tfoot td {
            padding: 6px 10px;
            font-size: 9px;
            color: #A8ABA7;
            font-style: italic;
        }
        /* ── SEVERITY BADGE ───────────────────────────────── */
        .badge-ringan { color: #166534; font-weight: bold; }
        .badge-sedang { color: #92400E; font-weight: bold; }
        .badge-parah  { color: #991B1B; font-weight: bold; }
        /* ── LIFESTYLE TABLE ──────────────────────────────── */
        .lifestyle-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .lifestyle-table thead tr { background-color: #5D605C; color: #FFFFFF; }
        .lifestyle-table thead td { padding: 8px 10px; font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .lifestyle-table thead td:first-child { border-radius: 4px 0 0 0; }
        .lifestyle-table thead td:last-child  { border-radius: 0 4px 0 0; }
        .lifestyle-table tbody tr:nth-child(even) { background-color: #F5F5F3; }
        .lifestyle-table tbody tr:nth-child(odd)  { background-color: #FFFFFF; }
        .lifestyle-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #EDE9E5;
        }
        .risk-high   { color: #991B1B; font-weight: bold; }
        .risk-medium { color: #92400E; font-weight: bold; }
        .risk-low    { color: #166534; font-weight: bold; }
        /* ── DISCLAIMER ───────────────────────────────────── */
        .disclaimer-box {
            margin-top: 24px;
            border: 1px solid #E1DDD9;
            border-left: 4px solid #A8ABA7;
            background-color: #F9F9F8;
            padding: 10px 14px;
            border-radius: 0 4px 4px 0;
        }
        .disclaimer-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #5D605C;
            margin-bottom: 4px;
        }
        .disclaimer-text {
            font-size: 9px;
            color: #797B78;
            line-height: 1.7;
        }
        /* ── FOOTER ───────────────────────────────────────── */
        .doc-footer {
            position: fixed;
            bottom: 16px;
            left: 0; right: 0;
            text-align: center;
            font-size: 8px;
            color: #C5C5C5;
            border-top: 1px solid #EDE9E5;
            padding-top: 6px;
        }
        /* ── PROGRESS BAR (pure CSS, DomPDF compatible) ───── */
        .progress-track {
            width: 100%;
            height: 6px;
            background-color: #E1DDD9;
            border-radius: 3px;
            margin-top: 8px;
        }
        .progress-fill {
            height: 6px;
            background-color: #8B3A3A;
            border-radius: 3px;
        }
        .no-data { color: #A8ABA7; font-style: italic; font-size: 10px; padding: 10px 0; }
    </style>
</head>
<body>

    {{-- ════════════════════════════════════════════════ --}}
    {{-- KOP SURAT                                       --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="letterhead">
        <div class="letterhead-inner">
            <div class="letterhead-logo-cell">
                <div class="logo-box">E</div>
            </div>
            <div class="letterhead-info-cell">
                <div class="clinic-name">The Ethereal Clinic</div>
                <div class="clinic-subtitle">Dermatology &amp; Skin Care Excellence</div>
                <div class="clinic-address">
                    Jl. Kulit Sehat No. 1, Jakarta Selatan &nbsp;|&nbsp;
                    Telp: (021) 555-0100 &nbsp;|&nbsp;
                    info@etherealclinic.id
                </div>
            </div>
            <div class="letterhead-date-cell">
                <span class="doc-label">Tanggal Dokumen</span>
                {{ $generated_at }}
                <br><br>
                <span class="doc-label">No. Rekam Medis</span>
                #{{ $history->id ?? '-' }}
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════ --}}
    {{-- DATA PASIEN                                     --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="section-title">Data Pasien</div>
    <table class="patient-table">
        <tr>
            <td>Nama Lengkap</td>
            <td><strong>{{ $user->name ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $user->email ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Skrining</td>
            <td>{{ $tanggal }}</td>
        </tr>
        <tr>
            <td>Jenis Analisis</td>
            <td>Skrining Kulit Hybrid (AI Visual + Gaya Hidup)</td>
        </tr>
        <tr>
            <td>Total Objek Terdeteksi</td>
            <td>{{ $total_objek_terdeteksi }} objek</td>
        </tr>
    </table>

    {{-- ════════════════════════════════════════════════ --}}
    {{-- SKOR KESEHATAN                                  --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="section-title">Skor Kesehatan Wajah</div>
    <div class="score-box">
        <div class="score-left">
            <div class="score-number">{{ $skor_kesehatan }}</div>
            <span class="score-of">dari 100</span>
        </div>
        <div class="score-right">
            <span class="score-label">{{ $kondisi_label }}</span>
            <div class="score-desc">
                Skor dihitung menggunakan algoritma Certainty Factor (CF) Hybrid.<br>
                Semakin tinggi skor, semakin sehat kondisi kulit Anda.
            </div>
            <span class="cf-badge">CF Risiko: {{ round($cf_final * 100, 1) }}%</span>
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ $skor_kesehatan }}%;"></div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════ --}}
    {{-- TEMUAN KLINIS AI                                --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="section-title">Temuan Klinis AI (Deteksi Visual)</div>
    @if(count($temuan_klinis) > 0)
    <table class="result-table">
        <thead>
            <tr>
                <td style="width:5%">#</td>
                <td style="width:25%">Objek Terdeteksi</td>
                <td style="width:15%">Jumlah</td>
                <td style="width:20%">Tingkat</td>
                <td style="width:18%">Keyakinan AI</td>
                <td style="width:17%">CF Kontribusi</td>
            </tr>
        </thead>
        <tbody>
            @foreach($temuan_klinis as $i => $item)
            @php
                $badgeClass = match($item['tingkat_keparahan']) {
                    'Ringan' => 'badge-ringan',
                    'Sedang' => 'badge-sedang',
                    'Parah'  => 'badge-parah',
                    default  => ''
                };
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $item['nama_objek'] }}</strong></td>
                <td>{{ $item['jumlah'] }} buah</td>
                <td class="{{ $badgeClass }}">{{ $item['tingkat_keparahan'] }}</td>
                <td>{{ round($item['avg_confidence'] * 100) }}%</td>
                <td><strong>{{ round($item['cf_final'] * 100, 1) }}%</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="6">* CF Kontribusi = CF Pakar × Rata-rata Keyakinan AI per objek</td></tr>
        </tfoot>
    </table>
    @else
    <p class="no-data">Tidak ada objek kulit bermasalah yang terdeteksi pada foto yang diunggah.</p>
    @endif

    {{-- ════════════════════════════════════════════════ --}}
    {{-- RANGKUMAN GAYA HIDUP                            --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="section-title">Rangkuman Faktor Gaya Hidup</div>
    @if(count($lifestyle_detail) > 0)
    <table class="lifestyle-table">
        <thead>
            <tr>
                <td style="width:5%">#</td>
                <td style="width:28%">Kategori</td>
                <td style="width:40%">Pilihan Pengguna</td>
                <td style="width:15%">Tingkat Risiko</td>
                <td style="width:12%">CF</td>
            </tr>
        </thead>
        <tbody>
            @foreach($lifestyle_detail as $i => $item)
            @php
                $cf      = $item['cf_pakar'] * 100;
                $riskCls = match(true) {
                    $cf >= 50 => 'risk-high',
                    $cf >= 20 => 'risk-medium',
                    default   => 'risk-low',
                };
                $riskLabel = match(true) {
                    $cf >= 50 => 'Tinggi',
                    $cf >= 20 => 'Sedang',
                    default   => 'Rendah',
                };
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $item['kategori'] }}</strong></td>
                <td>{{ $item['label'] }}</td>
                <td class="{{ $riskCls }}">{{ $riskLabel }}</td>
                <td><strong>{{ round($cf, 1) }}%</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="5">* CF 0% = tidak berkontribusi terhadap risiko jerawat</td></tr>
        </tfoot>
    </table>
    @else
    <p class="no-data">Data gaya hidup tidak tersedia.</p>
    @endif

    {{-- ════════════════════════════════════════════════ --}}
    {{-- MEDICAL DISCLAIMER                              --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div class="disclaimer-box">
        <div class="disclaimer-title">⚠ Medical Disclaimer</div>
        <div class="disclaimer-text">
            Sistem ini adalah alat bantu skrining kecerdasan buatan (AI-powered screening tool) yang dikembangkan
            oleh The Ethereal Clinic. Hasil analisis ini <strong>bukan merupakan diagnosis medis resmi</strong>.
            Diagnosis akhir dan tindakan medis tetap memerlukan pemeriksaan langsung oleh dokter spesialis kulit
            (Dermatologis) yang berkualifikasi. Jangan menunda atau mengabaikan nasihat medis profesional berdasarkan
            hasil skrining ini. Segera konsultasikan dengan tenaga medis berlisensi untuk penanganan lebih lanjut.
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="doc-footer">
        Dokumen ini digenerate secara otomatis oleh sistem AI The Ethereal Clinic &nbsp;·&nbsp;
        {{ $generated_at }} &nbsp;·&nbsp; Ref #{{ $history->id ?? '-' }}
    </div>

</body>
</html>
