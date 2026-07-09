{{-- Hero halaman Profile: judul "Struktur Pemerintah" di atas latar kantor (frosted) --}}
@php
    $aboutImages = Storage::disk('public')->allFiles('aboutus');
    $heroBg = count($aboutImages) > 0
        ? Storage::url($aboutImages[0])
        : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1600&auto=format&fit=crop';
@endphp

<div class="relative w-full min-h-[240px] h-[32vh] lg:h-[40vh] overflow-hidden flex items-center justify-center">
    <!-- Latar blur + frosted -->
    <div class="absolute inset-0">
        <img src="{{ $heroBg }}" class="w-full h-full object-cover blur-[3px] scale-105" alt="Struktur Pemerintah Kabupaten Pasuruan" decoding="async">
        <div class="absolute inset-0 bg-white/70"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-transparent to-white/70"></div>
    </div>

    <!-- Judul -->
    <div class="relative z-10 text-center px-4" data-aos="fade-up">
        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight">STRUKTUR PEMERINTAH</h1>
        <p class="mt-3 text-[11px] sm:text-sm text-slate-500 uppercase tracking-[0.3em]">Kabupaten Pasuruan 2025 &ndash; 2029</p>
        <span class="block w-16 h-1 rounded-full bg-[#2563eb] mx-auto mt-4"></span>
    </div>
</div>
