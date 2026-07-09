@extends('layouts.landing-base')

@section('css')
    <style>
        .tiptap * {
            all: revert;
            max-width: 100%;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="lg:max-w-[85%] py-10 mx-auto px-4 sm:px-6">

        <div class="flex flex-col lg:flex-row gap-12">

            <div class="w-full lg:w-[70%]">
                <div class="mb-8">
                    <h1 class="mb-6 text-3xl font-extrabold sm:text-4xl lg:text-5xl leading-tight text-gray-900">
                        {{ $data['article']->title }}
                    </h1>

                    <div class="flex items-center gap-4 mb-8 text-sm text-gray-600">
                        <img class="rounded-full w-12 h-12 object-cover shadow-md border-2 border-white ring-1 ring-gray-100"
                            src="{{ $data['article']->creator->profile_image ? Storage::url($data['article']->creator->profile_image) : 'https://ui-avatars.com/api/?name=' . $data['article']->creator->name }}"
                            alt="{{ $data['article']->creator->name }}">
                        <div class="flex flex-col">
                            <p class="font-bold text-gray-900 text-base leading-none mb-1">
                                {{ $data['article']->creator->name }}</p>
                            <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                {{-- Menampilkan Tanggal, Bulan, Tahun, dan Jam:Menit --}}
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    {{ \Carbon\Carbon::parse($data['article']->published_at)->translatedFormat('d F Y') }}
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($data['article']->published_at)->format('H:i') }} WITA
                                </span>
                                {{-- Opsional: Tambahkan format "2 jam yang lalu" (diffForHumans) --}}
                                <span class="hidden md:inline text-[#2563eb]/60 bg-[#2563eb]/5 px-2 py-0.5 rounded ml-1">
                                    ({{ \Carbon\Carbon::parse($data['article']->published_at)->diffForHumans() }})
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mb-8 overflow-hidden rounded-2xl shadow-lg">
                    <img src="{{ Storage::url($data['article']->cover?->path) }}" alt="{{ $data['article']->cover?->alt }}"
                        class="w-full h-[250px] sm:h-[400px] lg:h-[500px] object-cover object-center">
                </div>

                <div class="mt-4 text-gray-800 tiptap prose prose-lg max-w-none leading-relaxed">
                    {!! tiptap_converter()->asHTML($data['article']->content) !!}
                </div>

                {{-- Tags Section --}}
                <div class="mt-12 pt-8">
                    <div class="relative mb-8 pb-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <h3 class="text-xl font-extrabold text-gray-900 uppercase tracking-tight">Topik Terkait</h3>
                        </div>

                        <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gray-200"></div>

                        <div class="absolute bottom-0 left-0 w-24 h-[3px] bg-[#2563eb] z-10"></div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        @foreach ($data['article']->tags as $tag)
                            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:scale-105">
                                <x-links.tag search="{{ $data['navigation']['search'] ? true : false }}"
                                    category="{{ $data['article']->category->slug }}" tag='{{ $tag->tag_name }}'
                                    slug='{{ $tag->slug }}'
                                    class="!inline-flex !items-center !px-8 !py-4 !text-base lg:!text-lg !font-black !uppercase !tracking-widest !rounded-2xl !bg-gray-100 !text-gray-800 hover:!bg-[#2563eb] hover:!text-white shadow-md hover:shadow-xl border border-gray-200/50" />
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sponsor Section --}}
                @if (!$data['article']->sponsors->isEmpty())
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        @include('sections.others.sponsors')
                    </div>
                @endif
            </div>

            <div class="w-full lg:w-[30%]">
                <div class="sticky top-24">
                    <div class="relative mb-8 pb-4">
                        <h2 class="text-xl font-extrabold text-gray-900 uppercase tracking-tight">
                            {{ $data['article']->category->category_name }} Lainnya
                        </h2>

                        <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gray-200"></div>

                        <div class="absolute bottom-0 left-0 w-32 h-[3px] bg-[#2563eb] z-10"></div>
                    </div>
                    @if (!$data['related']->isEmpty())
                        <div class="flex flex-col gap-6">
                            @foreach($data['related'] as $related)
                                {{-- Kita ganti routenya agar langsung ke halaman detail artikel tersebut --}}
                                <a href="{{ route('detail', ['category' => $related->category->slug, 'slug' => $related->slug]) }}"
                                    class="group flex gap-4 transition-all duration-300 hover:bg-gray-50 p-2 rounded-xl">
                                    <div class="w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 shadow-sm">
                                        <img src="{{ Storage::url($related->cover?->path) }}"
                                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                                            alt="{{ $related->title }}">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h4
                                            class="text-sm font-bold leading-tight text-gray-800 group-hover:text-[#2563eb] transition-colors line-clamp-2">
                                            {{ $related->title }}
                                        </h4>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span
                                                class="text-[10px] font-bold text-[#2563eb] bg-[#2563eb]/10 px-2 py-0.5 rounded uppercase">
                                                {{ $related->category->category_name }}
                                            </span>
                                            <span class="text-[10px] text-gray-400">
                                                {{ \Carbon\Carbon::parse($related->published_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm italic">Belum Ada {{ $data['article']->category->category_name }}
                            Terkait.</p>
                    @endif

                    {{-- CTA Box --}}
                </div>
            </div>
        </div>
    </div>
@endsection