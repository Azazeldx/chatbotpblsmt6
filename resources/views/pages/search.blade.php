@extends('layouts.landing-base')

@section('content')
    <form class="flex flex-col gap-4 px-8 pt-12 lg:pt-20 md:flex-row lg:px-40" action="{{ route($data['page']->slug) }}" method="GET" id="searchForm">
        <!-- Select (Data) Field -->
        <div class="w-full flex-0 md:w-auto">
            <select name="category" class="w-full text-sm border-gray-300 rounded-md">
                @foreach ($data['categories'] as $category)
                    <option value="{{ $category->slug }}" @selected($request->category ? $request->category == $category->slug : $category->default)>{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Search Field -->
        <div class="flex-1 w-full">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" name="search" class="block w-full py-2 text-sm text-gray-900 border border-gray-300 rounded-lg pe-4 ps-10 bg-gray-50 focus:ring-[#2563eb] focus:border-[#2563eb] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#2563eb] dark:focus:border-[#2563eb]" placeholder="Search" value="{{ $request->search }}" />
            </div>
        </div>

        <!-- Dropdown Button -->
        <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white rounded-lg bg-secondary-500 hover:scale-105 focus:ring-2 focus:outline-none focus:ring-secondary-600 md:w-auto" type="button">Tags
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdownSearch" class="z-50 hidden bg-white rounded-lg shadow w-60 sm:w-96 dark:bg-gray-700">
            <ul class="grid grid-cols-1 p-3 overflow-y-auto text-sm text-gray-700 sm:grid-cols-2 max-h-48 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
                @if ($data['tags']->isEmpty())
                    <p>Tags tidak ditemukan</p>
                @endif
                @foreach ($data['tags'] as $index => $item)
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            @if ($request->filled('tags'))
                                @if (in_array($item->slug, explode(',', $request->tags)))
                                    <input id="checkbox-item-{{ $item->id }}" type="checkbox" name="tags" value="{{ $item->slug }}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-secondary-500" checked>
                                    <label for="checkbox-item-{{ $index+1 }}" class="w-full text-sm font-medium text-gray-900 rounded ms-2 dark:text-gray-300">{{ $item->tag_name }}</label>
                                @else
                                    <input id="checkbox-item-{{ $item->id }}" type="checkbox" name="tags" value="{{ $item->slug }}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-secondary-500">
                                    <label for="checkbox-item-{{ $index+1 }}" class="w-full text-sm font-medium text-gray-900 rounded ms-2 dark:text-gray-300">{{ $item->tag_name }}</label>
                                @endif
                            @else
                                <input id="checkbox-item-{{ $item->id }}" type="checkbox" name="tags" value="{{ $item->slug }}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-secondary-500">
                                <label for="checkbox-item-{{ $index+1 }}" class="w-full text-sm font-medium text-gray-900 rounded ms-2 dark:text-gray-300">{{ $item->tag_name }}</label>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <input type="hidden" id="tagsInput" name="tags">

        <!-- Submit Button -->
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white transition-transform transform rounded-lg bg-secondary-500 hover:scale-105 md:w-auto">Search</button>
    </form>

    <div class="px-8 py-12 mx-auto lg:px-40 lg:py-20 max-w-screen-3xl">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @if ($data['result']->isEmpty())
                <p class="text-xl text-center">Hasil tidak ditemukan</p>
            @else
                @foreach ($data['result'] as $item)
                    @include('components.category_cards.'.$item->category->card_layout)
                @endforeach
            @endif
        </div>
        {{ $data['result']->links() }}
    </div>

    @foreach ($data['page']->sections as $section)
        @php
            $section = $section->section;
        @endphp
        @include('sections.'.$section->layout_path)
    @endforeach()
@endsection

@section('js')
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let tagsInputs = document.querySelectorAll('input[name="tags"]:checked');
            let tagsMap = Array.from(tagsInputs).map(checkbox => checkbox.value);
            tagsInputs.forEach(checkbox => {checkbox.removeAttribute('name');});

            document.getElementById('tagsInput').value = tagsMap.join(',');

            this.submit();
        });
    </script>
@endsection
