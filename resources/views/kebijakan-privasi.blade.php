@extends('landingpage.app')

@section('title', 'Kebijakan Privasi - The Ethereal Clinic')

@section('content')
    <header class="w-full bg-white border-b border-gray-200 py-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-[#68575E] tracking-tight mb-4">Kebijakan Privasi</h1>
            <p class="text-[#72544E] text-lg">Terakhir diperbarui: 16 April 2026</p>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-16 bg-white shadow-sm mt-[-2rem] rounded-t-3xl relative z-10 border-x border-gray-100 mb-20">
        <div class="prose prose-lg text-[#5D605C] max-w-none prose-headings:text-[#68575E] prose-headings:font-bold prose-a:text-[#8A3033]">
            <p class="lead text-xl text-[#72544E] font-medium mb-10 border-l-4 border-[#8A3033] pl-6 bg-[#FFEFF3]/30 py-4 rounded-r-xl">
                Privasi dan keamanan data medis Anda adalah prioritas utama kami. Dokumen ini menjelaskan bagaimana The Ethereal Clinic mengumpulkan, menggunakan, dan melindungi informasi Anda.
            </p>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">1. Pengumpulan Data</h2>
            <p>Kami mengumpulkan beberapa jenis informasi untuk memberikan dan meningkatkan layanan klinis kami kepada Anda, termasuk:</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li><strong>Data Pribadi:</strong> Nama lengkap, alamat email, nomor telepon, dan informasi demografis.</li>
                <li><strong>Data Medis Pribadi:</strong> Riwayat kesehatan kulit, foto kondisi kulit yang Anda unggah, dan catatan konsultasi dengan dokter kami.</li>
                <li><strong>Data Teknis:</strong> Alamat IP, jenis browser, dan data *cookies* saat Anda berinteraksi dengan platform kami.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">2. Penggunaan Informasi</h2>
            <p>Data yang kami kumpulkan semata-mata digunakan untuk tujuan operasional medis dan peningkatan pengalaman pasien, meliputi:</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li>Memfasilitasi diagnosis kulit menggunakan teknologi Kecerdasan Buatan (AI) secara presisi.</li>
                <li>Menghubungkan Anda dengan spesialis dermatologi yang tepat.</li>
                <li>Memenuhi kewajiban tata kelola medis (*medical compliance*) dan audit internal.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">3. Keamanan & Enkripsi Data</h2>
            <p>Sistem Ethereal Clinic dibangun dengan arsitektur keamanan tingkat tinggi. Kami menerapkan <strong>Role-Based Access Control (RBAC)</strong> untuk memastikan data medis Anda hanya dapat diakses oleh Anda dan dokter yang menangani. Seluruh kata sandi dienkripsi menggunakan protokol *hashing* yang tidak dapat didekripsi, dan koneksi platform dilindungi oleh SSL.</p>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">4. Analisis Kecerdasan Buatan (AI)</h2>
            <p>Gambar kulit dan hasil diagnosis yang diproses oleh AI kami akan dianonimkan (dihapus dari identitas pribadi Anda) sebelum digunakan untuk meningkatkan akurasi algoritma kami. Anda memiliki hak penuh untuk meminta agar data Anda tidak dilibatkan dalam pelatihan sistem ini.</p>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">5. Hak Anda</h2>
            <p>Sesuai dengan regulasi pelindungan data pribadi yang berlaku, Anda berhak untuk:</p>
            <ul class="list-disc pl-6 space-y-2 mb-6">
                <li>Meminta salinan data pribadi dan rekam medis Anda.</li>
                <li>Meminta koreksi jika terdapat data yang tidak akurat.</li>
                <li>Meminta penghapusan permanen akun dan seluruh riwayat data Anda dari server kami.</li>
            </ul>

            <h2 class="text-2xl mt-10 mb-4 border-b pb-2">6. Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan mengenai praktik tata kelola privasi kami, silakan hubungi tim keamanan dan kepatuhan kami melalui:</p>
            <p class="font-medium bg-gray-50 p-4 rounded-xl border border-gray-200 inline-block">Email: privacy@etherealclinic.id</p>
        </div>
    </main>
@endsection