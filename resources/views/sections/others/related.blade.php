@extends('sections.layouts.pagination.4_columns')

@section('title')
    <div class="relative flex flex-col items-center mb-8 space-y-2 border-b-2 border-gray-200">
        <h1 class="pb-4 text-2xl font-semibold border-b-4 border-red sm:text-3xl lg:text-4xl">{{ $data['related']->first()->category->category_name }} Terkait</h1>
    </div>
@overwrite

@section('items')
    @if ($data['related']->isEmpty())
        <p class="text-xl text-center">Hasil tidak ditemukan</p>
    @else
        @foreach ($data['related'] as $item)
            @include('components.category_cards.'.$data['related']->first()->category->card_layout)
        @endforeach
    @endif
@overwrite

@section('pagination')
    @if ($data['navigation']['search'])
        <div class="flex justify-center py-4 border-b-2">
            <a href="{{ route($data['navigation']['search']['slug'], ['category' => $data['related']->first()->category->slug]) }}" class="flex items-center gap-2 font-semibold transition-transform text-[#2563eb] hover:scale-105">
                See All
            </a>
        </div>
    @endif
@overwrite
