{{-- Halaman Kontak: form aspirasi + kartu informasi kantor --}}
@php
    $officeAddress = $data['location']['address'] ?? 'Jl. Raya Raci Km. 9, Kec. Bangil, Kab. Pasuruan';
    $officePhone   = $data['contacts']['phone'] ?? '(0343) 748368';
    $officeEmail   = $data['contacts']['email'] ?? 'bapperida@pasuruankab.go.id';
    $officeMapUrl  = $data['location']['url'] ?? 'https://maps.google.com/?q=Bapperida+Kabupaten+Pasuruan';
@endphp

<section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 py-16 lg:py-24">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">

        <!-- Kiri: judul + form -->
        <div data-aos="fade-right">
            <span class="text-[#2563eb] font-bold tracking-[0.25em] text-xs uppercase">Saluran Aspirasi</span>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 leading-[0.95] mt-4 mb-5">
                Hubungi<br>Kami
            </h1>
            <p class="text-slate-500 text-base lg:text-lg leading-relaxed max-w-md mb-8">
                Layanan pengaduan dan informasi terbuka bagi seluruh masyarakat Kabupaten Pasuruan.
            </p>

            {{-- Flash message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm font-medium">
                    <i class="fas fa-circle-check mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm font-medium">
                    <i class="fas fa-circle-exclamation mr-1"></i> {{ session('danger') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm font-medium">
                    <i class="fas fa-circle-exclamation mr-1"></i> Mohon periksa kembali isian formulir Anda.
                </div>
            @endif

            <form action="{{ route('mail') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <input type="text" name="name" required value="{{ old('name') }}"
                        placeholder="Nama Lengkap *"
                        class="w-full px-4 py-3.5 text-sm bg-slate-50 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:bg-white transition">
                    <input type="email" name="email" required value="{{ old('email') }}"
                        placeholder="Email Anda *"
                        class="w-full px-4 py-3.5 text-sm bg-slate-50 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:bg-white transition">
                </div>

                <input type="text" name="subject" required value="{{ old('subject') }}"
                    placeholder="Subjek Pesan *"
                    class="w-full px-4 py-3.5 text-sm bg-slate-50 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:bg-white transition">

                <textarea name="message" required rows="6"
                    placeholder="Deskripsikan pertanyaan atau aspirasi Anda secara detail..."
                    class="w-full px-4 py-3.5 text-sm bg-slate-50 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:bg-white transition resize-none">{{ old('message') }}</textarea>

                <button type="submit"
                    class="w-full py-4 rounded-xl text-white text-sm font-bold uppercase tracking-widest shadow-lg shadow-blue-500/30 transition hover:-translate-y-0.5 hover:shadow-xl"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    Kirim Aspirasi Sekarang
                </button>
            </form>
        </div>

        <!-- Kanan: kartu informasi kantor -->
        <div data-aos="fade-left" class="lg:mt-4">
            <div class="relative bg-white rounded-3xl shadow-[0_20px_50px_-20px_rgba(15,23,42,0.25)] border border-slate-100 p-8 lg:p-10 overflow-hidden">
                <!-- Lipatan sudut -->
                <div class="absolute top-0 right-0 w-0 h-0" style="border-top: 64px solid #2563eb; border-left: 64px solid transparent;"></div>

                <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Informasi Kantor</h2>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider leading-relaxed mb-8 max-w-xs">
                    Pusat Data dan Perencanaan Pembangunan Daerah Bapperrida
                </p>

                <div class="space-y-6">
                    <!-- Lokasi -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-location-dot text-[#2563eb]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Lokasi</p>
                            <p class="text-sm font-bold text-slate-800 leading-snug">{{ $officeAddress }}</p>
                        </div>
                    </div>

                    <!-- Layanan / telepon -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-phone text-[#2563eb]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Layanan</p>
                            <a href="tel:{{ $officePhone }}" class="text-sm font-bold text-slate-800 hover:text-[#2563eb] transition">{{ $officePhone }}</a>
                        </div>
                    </div>

                    <!-- Surat elektronik -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-envelope text-[#2563eb]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Surat Elektronik</p>
                            <a href="mailto:{{ $officeEmail }}" class="text-sm font-bold text-slate-800 hover:text-[#2563eb] transition break-all">{{ $officeEmail }}</a>
                        </div>
                    </div>
                </div>

                <a href="{{ $officeMapUrl }}" target="_blank" rel="noopener"
                   class="mt-8 flex items-center justify-center w-full py-3.5 rounded-xl border-2 border-slate-900 text-slate-900 text-[11px] font-bold uppercase tracking-widest transition hover:bg-slate-900 hover:text-white">
                    Lihat pada Peta
                </a>
            </div>
        </div>
    </div>
</section>
