@extends('layouts.app')

@section('title', 'Kebijakan Privasi')
@section('meta_description', 'Kebijakan Privasi BagiResep. Kami berkomitmen melindungi data pribadi Anda dengan standar keamanan tertinggi.')

@section('content')
<section class="relative bg-walnut-900 overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_top,rgba(217,164,65,0.3),transparent_70%)]"></div>
    <div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-20 md:py-28 text-center relative">
        <p class="text-amber-400/60 text-xs uppercase tracking-[0.4em] font-bold mb-4">Kebijakan Privasi</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-tight">Privasi Anda,<br>Tanggung Jawab Kami</h1>
        <p class="text-cream-300/50 text-base mt-6 max-w-xl mx-auto leading-relaxed">Kami berkomitmen penuh untuk melindungi data pribadi setiap pengguna BagiResep.</p>
        <p class="text-cream-400/30 text-xs mt-8">Berlaku efektif: {{ date('d F Y') }}</p>
    </div>
</section>

<div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-16 md:py-24">
    <div class="prose prose-lg max-w-none">

        <div class="mb-16">
            <p class="text-base text-gray-500 leading-relaxed">BagiResep adalah platform berbagi resep masakan yang dikelola oleh <strong class="text-charcoal-500">Gempur Budi Anarki</strong>. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi Anda saat menggunakan layanan kami. Dengan mengakses BagiResep, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini.</p>
        </div>

        <div class="space-y-16">
            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">01</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Informasi yang Dikumpulkan</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Kami mengumpulkan informasi yang Anda berikan secara langsung maupun yang dihasilkan secara otomatis saat menggunakan platform:</p>
                    <div class="bg-cream-50 rounded-2xl p-6 border border-cream-200 space-y-3">
                        <p><strong class="text-charcoal-500">Informasi Akun.</strong> Nama, alamat email, dan password terenkripsi yang diberikan saat pendaftaran.</p>
                        <p><strong class="text-charcoal-500">Konten Pengguna.</strong> Resep, foto, deskripsi, bahan, langkah memasak, rating, dan review yang diunggah ke platform.</p>
                        <p><strong class="text-charcoal-500">Data Interaksi.</strong> Bookmark, pencarian, dan preferensi kategori yang Anda lakukan di dalam platform.</p>
                        <p><strong class="text-charcoal-500">Data Teknis.</strong> Alamat IP, jenis peramban, sistem operasi, dan halaman yang dikunjungi untuk keperluan keamanan dan diagnostik.</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">02</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Penggunaan Informasi</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Informasi yang dikumpulkan digunakan untuk:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Menyediakan dan memelihara layanan platform</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Mempersonalisasi pengalaman pengguna</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Mengirim komunikasi penting terkait akun</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Mendeteksi dan mencegah aktivitas mencurigakan</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Menganalisis penggunaan untuk peningkatan fitur</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Menegakkan Syarat Penggunaan</div>
                    </div>
                    <div class="bg-red-50/70 rounded-2xl p-5 border border-red-100 mt-6">
                        <p class="text-red-600 font-semibold text-sm mb-2">Kami tidak pernah:</p>
                        <ul class="space-y-1.5 text-red-600 text-sm">
                            <li>Menjual data pribadi kepada pihak ketiga</li>
                            <li>Menggunakan data Anda untuk periklanan bertarget</li>
                            <li>Membagikan informasi kontak tanpa izin eksplisit</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">03</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Perlindungan Data</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasional untuk melindungi data Anda:</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">01</span>
                            <p><strong class="text-charcoal-500">Enkripsi.</strong> Password di-hash menggunakan algoritma bcrypt. Data dalam perjalanan dilindungi dengan enkripsi TLS/SSL.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">02</span>
                            <p><strong class="text-charcoal-500">Akses Terbatas.</strong> Hanya administrator BagiResep yang memiliki akses ke data sensitif, dengan autentikasi ketat.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">03</span>
                            <p><strong class="text-charcoal-500">Pemantauan.</strong> Sistem kami secara berkala diperiksa terhadap kerentanan keamanan yang diketahui.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">04</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Cookie</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>BagiResep menggunakan cookie sesi esensial yang diperlukan untuk fungsi dasar platform — seperti mempertahankan status login dan melindungi dari serangan CSRF. Cookie ini bersifat sementara dan dihapus saat Anda menutup peramban.</p>
                    <p>Kami <strong class="text-charcoal-500">tidak menggunakan</strong> cookie pelacakan, cookie periklanan, atau cookie pihak ketiga dalam bentuk apapun.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">05</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Penyimpanan Data</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Data Anda disimpan di server yang berlokasi di Indonesia. Kami menyimpan informasi akun selama akun Anda aktif. Konten yang dihapus akan disimpan maksimal 30 hari sebelum dihapus permanen. Data mungkin tetap ada dalam cadangan sistem hingga 90 hari.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">06</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Hak Pengguna</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Anda memiliki hak penuh atas data pribadi Anda:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Hak Akses</p>
                            <p class="text-sm text-gray-400">Lihat data Anda kapan saja melalui halaman Profil</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Hak Koreksi</p>
                            <p class="text-sm text-gray-400">Perbarui nama, email, dan password Anda</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Hak Penghapusan</p>
                            <p class="text-sm text-gray-400">Hapus resep, review, atau seluruh akun</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Hak Portabilitas</p>
                            <p class="text-sm text-gray-400">Minta salinan data dalam format terstruktur</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">07</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Anak-Anak</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>BagiResep tidak ditujukan untuk individu di bawah usia 13 tahun. Kami tidak secara sadar mengumpulkan informasi pribadi dari anak-anak. Jika Anda adalah orang tua atau wali dan mengetahui anak Anda memberikan data pribadi kepada kami, hubungi kami segera untuk penghapusan data tersebut.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">08</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Perubahan Kebijakan</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Kebijakan ini dapat diperbarui dari waktu ke waktu untuk mencerminkan perubahan praktik atau persyaratan hukum. Perubahan material akan diumumkan melalui email atau pemberitahuan di platform. Penggunaan berkelanjutan atas layanan setelah perubahan merupakan persetujuan Anda.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">09</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Kontak</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Untuk pertanyaan, permintaan data, atau kekhawatiran tentang privasi:</p>
                    <div class="flex flex-col sm:flex-row gap-4 mt-4">
                        <a href="https://wa.me/6285600841078" target="_blank" rel="noopener" class="flex items-center gap-3 bg-white border border-gray-200 hover:border-green-300 rounded-2xl px-5 py-4 transition-all duration-200 group">
                            <span class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-xl group-hover:bg-green-100 transition-colors">WA</span>
                            <div><p class="font-bold text-sm text-charcoal-500">WhatsApp</p><p class="text-xs text-gray-400">0856-0008-41078</p></div>
                        </a>
                        <a href="mailto:icoth@bbg.ac.id" class="flex items-center gap-3 bg-white border border-gray-200 hover:border-amber-300 rounded-2xl px-5 py-4 transition-all duration-200 group">
                            <span class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-xl group-hover:bg-amber-100 transition-colors">@</span>
                            <div><p class="font-bold text-sm text-charcoal-500">Email</p><p class="text-xs text-gray-400">icoth@bbg.ac.id</p></div>
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
