<footer class="bg-slate-50 border-t border-slate-200" data-aos="fade-up">
    <div class="max-w-screen-2xl mx-auto px-6 sm:px-8 lg:!px-20 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Logo + deskripsi -->
            <div class="lg:col-span-2 max-w-sm">
                <img class="h-auto max-h-[80px] max-w-[100px] mb-5"
                     src="{{ !empty($data['site_logo']) ? asset('storage/'.$data['site_logo']) : asset('storage/others/logo_pasuruan.png') }}"
                     alt="{{ $data['site_name'] }}">
                <p class="text-sm text-slate-500 leading-relaxed">
                    Infrastruktur data perencanaan terpadu Kabupaten Pasuruan mewujudkan visi 2025&ndash;2029 yang bermartabat.
                </p>
            </div>

            <!-- Navigasi Situs -->
            <div>
                <h3 class="text-slate-800 font-bold text-sm uppercase tracking-wider pb-2 mb-4 border-b-2 border-[#2563eb] inline-block">
                    Navigasi Situs
                </h3>
                <ul class="flex flex-col space-y-3">
                    @if ($data['navigation']['home'])
                        <li>
                            <a href="{{ route($data['navigation']['home']['slug']) }}"
                               class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#2563eb] transition">
                                <i class="fas fa-angle-right text-[#2563eb] text-xs"></i> {{ $data['navigation']['home']['title'] }}
                            </a>
                        </li>
                    @endif
                    @foreach ($data['navigation']['nav_items'] as $navItem)
                        @if ($navItem['type'] == 'link' && !empty($navItem['link']))
                            <li>
                                <a href="{{ $navItem['link']['url'] }}"
                                   class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#2563eb] transition">
                                    <i class="fas fa-angle-right text-[#2563eb] text-xs"></i> {{ $navItem['link']['label'] }}
                                </a>
                            </li>
                        @elseif ($navItem['type'] == 'page' && !empty($navItem['page']))
                            <li>
                                <a href="{{ route($navItem['page']['slug']) }}"
                                   class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#2563eb] transition">
                                    <i class="fas fa-angle-right text-[#2563eb] text-xs"></i> {{ $navItem['page']['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Kontak Resmi -->
            <div>
                <h3 class="text-slate-800 font-bold text-sm uppercase tracking-wider pb-2 mb-4 border-b-2 border-[#2563eb] inline-block">
                    Kontak Resmi
                </h3>
                <div class="space-y-4">
                    @if (!empty($data['contacts']['email']))
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-slate-400 mb-1">Email</p>
                            <a href="mailto:{{ $data['contacts']['email'] }}"
                               class="text-sm font-semibold text-slate-700 hover:text-[#2563eb] transition break-all">
                                {{ $data['contacts']['email'] }}
                            </a>
                        </div>
                    @endif
                    @if (!empty($data['contacts']['phone']))
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-slate-400 mb-1">Telepon</p>
                            <a href="tel:{{ $data['contacts']['phone'] }}"
                               class="text-sm font-semibold text-slate-700 hover:text-[#2563eb] transition">
                                {{ $data['contacts']['phone'] }}
                            </a>
                        </div>
                    @endif

                    @if ($data['social_network'])
                        <div class="flex gap-3 pt-1">
                            @foreach ($data['social_network'] as $key => $value)
                                @if ($value['url'])
                                    <x-footer.social_network_item title="{{ $value['label'] }}" url="{{ $value['url'] }}" brand="{{ $key }}"/>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer bawah -->
    <div class="border-t border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-6 sm:px-8 lg:!px-20 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs uppercase tracking-wider text-slate-400">
                &copy; {{ date('Y') }} Pemerintah {{ $data['site_name'] }}
            </p>
            <div class="flex items-center gap-6 text-xs uppercase tracking-wider text-slate-400">
                <a href="#" class="hover:text-[#2563eb] transition">Privacy Policy</a>
                <a href="#" class="hover:text-[#2563eb] transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
