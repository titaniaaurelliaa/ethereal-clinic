@extends('layouts.public')

@section('title', 'Syarat & Ketentuan - The Ethereal Clinic')

@section('content')
    <header class="w-full bg-white border-b border-gray-200 py-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-[#68575E] tracking-tight mb-4">Syarat & Ketentuan</h1>
            <p class="text-[#72544E] text-lg">Berlaku efektif sejak: 16 April 2026</p>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-16 bg-white shadow-sm mt-[-2rem] rounded-t-3xl relative z-10 border-x border-gray-100 mb-20">
        <div class="prose prose-lg text-[#5D605C] max-w-none prose-headings:text-[#68575E] prose-headings:font-bold prose-a:text-[#8A3033]">
            <p class="lead text-xl text-[#72544E] font-medium mb-10 border-l-4 border-[#8A3033] pl-6 bg-[#FFEFF3]/30 py-4 rounded-r-xl">
                Dengan mengakses dan menggunakan platform The Ethereal Clinic, Anda menyetujui untuk terikat dengan Syarat & Ketentuan berikut. Harap baca dengan saksama.
            </p>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">1. Ketentuan Akun Pengguna</h2>
            <p>Untuk menggunakan layanan konsultasi dan analisis kami, Anda wajib membuat akun. Anda bertanggung jawab penuh untuk:</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li>Menjaga kerahasiaan kata sandi dan kredensial login Anda.</li>
                <li>Memberikan informasi medis dan identitas yang akurat dan terkini.</li>
                <li>Tidak meminjamkan atau memindahtangankan akun Anda kepada pihak ketiga.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">2. Sanggahan Medis (Medical Disclaimer)</h2>
            <p><strong>Penting:</strong> Layanan The Ethereal Clinic, termasuk analisis berbasis Kecerdasan Buatan (AI), dirancang sebagai alat bantu pendukung keputusan medis (*clinical decision support system*).</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li>Hasil analisis AI <strong>tidak menggantikan diagnosis fisik langsung</strong> dari dokter spesialis kulit.</li>
                <li>Kami tidak bertanggung jawab atas kerugian atau efek samping yang timbul dari pengobatan mandiri tanpa pengawasan langsung dari ahli medis kami.</li>
                <li>Dalam kondisi gawat darurat (seperti reaksi alergi parah atau infeksi kulit akut), Anda diwajibkan segera mengunjungi Instalasi Gawat Darurat (IGD) terdekat.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">3. Etika Penggunaan Platform</h2>
            <p>Anda setuju untuk tidak menggunakan platform ini untuk tindakan yang melanggar hukum, termasuk namun tidak terbatas pada:</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li>Mengunggah gambar yang tidak relevan dengan kondisi kulit, mengandung unsur pornografi, atau melanggar norma kesusilaan.</li>
                <li>Melakukan percobaan peretasan (*hacking*), injeksi sistem, atau tindakan yang membebani server klinik kami.</li>
                <li>Melakukan pelecehan verbal terhadap dokter atau staf medis kami selama sesi konsultasi.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">4. Pembekuan & Pemutusan Akun</h2>
            <p>Kami memiliki hak penuh untuk menangguhkan atau menghapus akun Anda tanpa pemberitahuan sebelumnya apabila ditemukan indikasi pelanggaran berat terhadap Syarat & Ketentuan ini atau indikasi penipuan identitas pasien.</p>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">5. Perubahan Ketentuan</h2>
            <p>The Ethereal Clinic berhak mengubah Syarat & Ketentuan ini kapan saja untuk menyesuaikan dengan regulasi pemerintah terbaru atau pembaruan fitur teknologi kami. Kami akan memberitahukan perubahan material melalui email yang terdaftar.</p>
        </div>
    </main>
@endsection