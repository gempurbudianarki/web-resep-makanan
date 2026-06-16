@extends('layouts.app')

@section('title', 'Syarat Penggunaan')
@section('meta_description', 'Syarat Penggunaan BagiResep. Ketentuan layanan yang adil dan transparan untuk menjaga komunitas tetap berkualitas.')

@section('content')
<section class="relative bg-walnut-900 overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_top,rgba(217,164,65,0.3),transparent_70%)]"></div>
    <div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-20 md:py-28 text-center relative">
        <p class="text-amber-400/60 text-xs uppercase tracking-[0.4em] font-bold mb-4">Syarat Penggunaan</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-tight">Aturan Main<br>yang Adil</h1>
        <p class="text-cream-300/50 text-base mt-6 max-w-xl mx-auto leading-relaxed">Komunitas yang sehat dibangun di atas aturan yang jelas dan transparan.</p>
        <p class="text-cream-400/30 text-xs mt-8">Berlaku efektif: {{ date('d F Y') }}</p>
    </div>
</section>

<div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-16 md:py-24">
    <div class="prose prose-lg max-w-none">

        <div class="mb-16">
            <p class="text-base text-gray-500 leading-relaxed">Selamat datang di BagiResep. Dengan mengakses atau menggunakan platform kami, Anda menyetujui Syarat Penggunaan ini. Mohon baca dengan saksama. Jika Anda tidak menyetujui ketentuan ini, jangan gunakan layanan kami.</p>
        </div>

        <div class="space-y-16">
            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">01</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Definisi</h2>
                </div>
                <div class="space-y-3 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p><strong class="text-charcoal-500">"Platform"</strong> merujuk pada situs web BagiResep yang beralamat di bagiresep.fun beserta seluruh layanan terkait.</p>
                    <p><strong class="text-charcoal-500">"Pengguna"</strong> merujuk pada setiap individu yang mengakses atau menggunakan Platform, baik terdaftar maupun tidak.</p>
                    <p><strong class="text-charcoal-500">"Konten"</strong> merujuk pada resep, foto, teks, komentar, rating, dan materi lain yang diunggah Pengguna ke Platform.</p>
                    <p><strong class="text-charcoal-500">"Kami"</strong> merujuk pada pengelola BagiResep.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">02</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Akun Pengguna</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Anda bertanggung jawab menjaga kerahasiaan kredensial akun Anda. Semua aktivitas yang terjadi di bawah akun Anda adalah tanggung jawab Anda.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Setiap individu hanya diperbolehkan memiliki satu akun. Akun ganda, akun palsu, atau impersonasi dilarang.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Anda harus berusia minimal 13 tahun untuk mendaftar akun di BagiResep.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">03</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Konten Pengguna</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Dengan mengunggah Konten ke Platform, Anda menyatakan dan menjamin bahwa:</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Konten adalah asli buatan Anda atau Anda memiliki izin sah untuk membagikannya.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Foto yang diunggah adalah hasil jepretan Anda sendiri, bukan unduhan dari internet tanpa izin.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Konten tidak melanggar hak kekayaan intelektual pihak lain.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">04</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Konten Terlarang</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Konten berikut dilarang keras di Platform:</p>
                    <div class="bg-red-50/70 rounded-2xl p-5 border border-red-100 space-y-3 text-red-700">
                        <p class="font-semibold text-sm mb-2">Pelanggaran dapat mengakibatkan penghapusan konten, penangguhan, atau penghapusan akun permanen:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Pornografi atau konten seksual eksplisit</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Ujaran kebencian atau diskriminasi</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Kekerasan atau ancaman</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Konten ilegal berdasarkan hukum Indonesia</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Spam atau iklan komersial</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Penipuan atau phishing</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Malware atau kode berbahaya</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span> Pelanggaran hak cipta</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">05</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Perilaku Pengguna</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Kami mengharapkan setiap Pengguna untuk:</p>
                    <div class="space-y-3">
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span> Berinteraksi dengan sopan dan menghormati sesama anggota komunitas</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span> Memberikan rating dan review berdasarkan pengalaman nyata</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span> Menggunakan bahasa yang santun dalam komentar dan review</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span> Melaporkan konten yang melanggar melalui jalur kontak</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">06</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Hak Kekayaan Intelektual</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Anda mempertahankan hak cipta atas Konten yang Anda buat. Dengan mengunggah Konten, Anda memberikan BagiResep lisensi non-eksklusif, bebas royalti, dan berlaku global untuk menampilkan dan mendistribusikan Konten tersebut di dalam Platform. Lisensi ini berakhir ketika Anda menghapus Konten dari Platform.</p>
                    <p>Nama "BagiResep", logo, desain antarmuka, dan kode sumber adalah kekayaan intelektual pengelola Platform dan dilindungi undang-undang.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">07</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Batasan Tanggung Jawab</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Platform disediakan "sebagaimana adanya" tanpa jaminan apapun. Kami tidak bertanggung jawab atas:</p>
                    <div class="space-y-2">
                        <p>- Hasil masakan yang tidak sesuai harapan berdasarkan resep</p>
                        <p>- Gangguan layanan atau pemeliharaan sistem</p>
                        <p>- Konten yang diunggah oleh Pengguna lain</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">08</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Penegakan</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Kami berhak, atas kebijakan kami sendiri, untuk:</p>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="bg-yellow-50/70 rounded-xl p-4 border border-yellow-100 flex items-start gap-3">
                            <span class="text-yellow-600 font-bold">I</span>
                            <p class="text-sm">Menghapus Konten yang melanggar ketentuan</p>
                        </div>
                        <div class="bg-orange-50/70 rounded-xl p-4 border border-orange-100 flex items-start gap-3">
                            <span class="text-orange-600 font-bold">II</span>
                            <p class="text-sm">Menangguhkan akun untuk pelanggaran berulang</p>
                        </div>
                        <div class="bg-red-50/70 rounded-xl p-4 border border-red-100 flex items-start gap-3">
                            <span class="text-red-600 font-bold">III</span>
                            <p class="text-sm">Menghapus permanen akun untuk pelanggaran berat</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">09</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Hukum yang Berlaku</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Syarat ini diatur oleh hukum Republik Indonesia. Setiap sengketa akan diselesaikan secara musyawarah terlebih dahulu, dan jika tidak tercapai kesepakatan, melalui pengadilan yang berwenang di Indonesia.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">10</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Kontak</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Untuk pertanyaan, laporan pelanggaran, atau permintaan banding:</p>
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
