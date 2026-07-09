{{-- Strategi Operasional RPJMD + Ksatria Pembangunan (halaman Profile) --}}
@php
    // Data program diambil dari config/programs.php (dipakai juga oleh halaman detail).
    $programs = config('programs', []);

    // Pemimpin dinamis — dikelola Super Admin lewat panel admin (Profil Daerah > Pemimpin Daerah).
    $leaders = \App\Models\Leader::active();
@endphp

<!-- Strategi Operasional RPJMD -->
<section class="bg-slate-50 py-16 lg:py-24" data-aos="fade-up">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20">
        <div class="text-center mb-12">
            <span class="text-[#2563eb] font-bold tracking-[0.25em] text-xs uppercase">Info Program Lengkap</span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3">Strategi Operasional RPJMD</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($programs as $slug => $p)
                <div
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 transition hover:shadow-xl hover:-translate-y-1">
                    <div class="w-11 h-11 rounded-xl {{ $p['bg'] }} flex items-center justify-center mb-5">
                        <i class="fas {{ $p['icon'] }}" style="color: {{ $p['color'] }}"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 mb-2">{{ $p['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6">{{ $p['desc'] }}</p>
                    <a href="{{ route('program.detail', $slug) }}"
                        class="inline-flex items-center justify-center w-full py-3 rounded-lg bg-slate-900 text-white text-[11px] font-bold uppercase tracking-widest transition hover:bg-slate-800">
                        Buka Detail Lengkap
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Ksatria Pembangunan -->
@if ($leaders->isNotEmpty())
    <section class="bg-white py-16 lg:py-24" data-aos="fade-up">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20">
            <div class="text-center mb-14">
                <span class="text-[#2563eb] font-bold tracking-[0.25em] text-xs uppercase">Pemimpin Masa Bakti</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3">Kepemimpinan Kabupaten Pasuruan</h2>
                <span class="block w-16 h-1 rounded-full bg-blue-200 mx-auto mt-4"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
                @foreach ($leaders as $leader)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 text-center transition hover:shadow-xl hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-slate-50 mx-auto mb-5 ring-4 ring-slate-100">
                            <img src="{{ $leader->photo_url }}" alt="{{ $leader->name }}" class="w-full h-full object-cover"
                                loading="lazy" decoding="async">
                        </div>
                        <span
                            class="text-[#2563eb] font-bold text-[11px] uppercase tracking-widest">{{ $leader->position }}</span>
                        <p class="text-lg font-extrabold text-slate-900 mt-1">{{ $leader->name }}</p>
                        @if ($leader->term)
                            <p class="text-slate-500 text-sm mt-1">Masa Bakti {{ $leader->term }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif