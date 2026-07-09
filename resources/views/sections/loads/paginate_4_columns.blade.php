@extends('sections.layouts.pagination.4_columns')

@section('title')
    @php
        // Judul menyesuaikan halaman (blade ini dipakai Home & Berita & Acara).
        $heading = match ($data['page']->slug ?? '') {
            'home'    => 'Kabar Pembangunan',
            'artikel' => 'Artikel Terbaru',
            default   => $section->dataset->category->category_name . ' Terbaru',
        };
    @endphp
    <div class="relative flex flex-col items-center mb-10">
        <h1 class="pb-3 text-2xl font-extrabold text-slate-900 sm:text-3xl lg:text-4xl">{{ $heading }}</h1>
        <span class="block w-16 h-1 rounded-full bg-[#2563eb]"></span>
    </div>
@overwrite

@section('items')
    @if ($data['loads'][$section->dataset->variable_name]->isEmpty())
        <p class="text-xl text-center">Hasil tidak ditemukan</p>
    @else
        @foreach ($data['loads'][$section->dataset->variable_name] as $item)
            @include('components.category_cards.'.$section->dataset->category->card_layout)
        @endforeach
    @endif
@overwrite

@section('pagination')
    @if ($section->dataset->paginate)
        {{ $data['loads'][$section->dataset->variable_name]->appends([$section->dataset->variable_name.'_page' => $data['loads'][$section->dataset->variable_name]->currentPage()])->links() }}
    @elseif ($data['navigation']['search'])
        <div class="flex justify-center pt-8">
            <a href="{{ route($data['navigation']['search']['slug'], ['category' => $section->dataset->category->slug]) }}" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-[#2563eb] transition hover:gap-3">
                Lihat Semua Berita <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    @endif
@overwrite
