@extends('layouts.landing-base')

@section('content')
    @php $program = $data['program']; @endphp

    <section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 py-10 lg:py-16">

        <!-- Kembali ke Profil -->
        <a href="{{ url('/profile') }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-[#2563eb] text-xs font-bold uppercase tracking-widest mb-10 transition">
            <i class="fas fa-xmark"></i> Kembali ke Profil
        </a>

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">

            <!-- Kiri: judul, deskripsi, sasaran -->
            <div data-aos="fade-up">
                <div class="w-14 h-14 rounded-2xl {{ $program['bg'] }} flex items-center justify-center mb-6 shadow-sm">
                    <i class="fas {{ $program['icon'] }} text-xl" style="color: {{ $program['color'] }}"></i>
                </div>

                <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-5">{{ $program['title'] }}</h1>

                <p class="text-slate-500 text-base lg:text-lg leading-relaxed mb-10">
                    {{ $program['detail'] }}
                </p>

                <div class="flex items-center gap-4 mb-6">
                    <h2 class="text-base font-extrabold uppercase tracking-widest text-slate-900 whitespace-nowrap">Sasaran Utama</h2>
                    <span class="flex-grow h-0.5 bg-blue-200 rounded-full"></span>
                </div>

                <ul class="space-y-3">
                    @foreach ($program['targets'] as $target)
                        <li class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3.5">
                            <span class="w-2 h-2 rounded-full bg-[#2563eb] flex-shrink-0"></span>
                            <span class="text-sm font-bold text-slate-800">{{ $target }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kanan: gambar -->
            <div class="lg:sticky lg:top-24" data-aos="fade-left">
                <div class="rounded-3xl overflow-hidden shadow-2xl aspect-square">
                    <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}"
                         class="w-full h-full object-cover" loading="lazy" decoding="async">
                </div>
            </div>
        </div>
    </section>
@endsection
