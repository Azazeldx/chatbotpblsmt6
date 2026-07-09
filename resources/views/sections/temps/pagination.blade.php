@extends('patterns.layouts.pagination')

@section('title')
    <div class="relative flex flex-col items-start mb-8 space-y-2 border-b-2 border-gray-200">
        <h1 class="pb-4 text-2xl font-semibold border-b-4 border-[#2563eb] sm:text-3xl lg:text-4xl">Artikel Terbaru</h1>
    </div>
@overwrite

@section('items')
    @if ($data['postpagination']->isEmpty())
        <p class="text-xl text-center">Hasil tidak ditemukan</p>
    @else
        @foreach ($data['postpagination'] as $item)
            @include('components.cardPost')
        @endforeach
    @endif
@overwrite

@section('pagination')
    {{ $data['postpagination']->links() }}
@overwrite
