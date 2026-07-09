@php
    $statePath = $getStatePath();
    $items = $getState() ?? [];
    $itemsCount = count($items);
    $isMultiple = $isMultiple();
    $maxItems = $getMaxItems();
    $shouldDisplayAsList = $shouldDisplayAsList();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">

    <div
        x-data="{
            insertMedia: function (event) {
                if (event.detail.statePath !== '{{ $statePath }}') return;
                $wire.$set(event.detail.statePath, event.detail.media);
            },
        }"
        x-on:insert-content.window="insertMedia($event)"
        class="curator-media-picker w-full"
    >
        <ul
            @class([
                'w-full',
                'flex items-center gap-6 flex-wrap' => $itemsCount <= 3 && ! $shouldDisplayAsList,
                'curator-grid-container' => $itemsCount >= 3 && ! $shouldDisplayAsList,
                'overflow-hidden bg-white border border-gray-300 rounded-lg shadow-sm divide-y divide-gray-300 dark:border-gray-700 dark:text-white dark:divide-gray-700 dark:bg-white/5' => $itemsCount > 0 && $shouldDisplayAsList,
            ])
            x-sortable
            wire:end.stop="mountFormComponentAction('{{ $statePath }}', 'reorder', { items: $event.target.sortable.toArray() })"
            style="{{ $itemsCount === 1 ? '--grid-column-count: 1' : '' }}"
        >
            @foreach ($items as $uuid => $item)
                <li
                    wire:key="{{ $this->getId() }}.{{ $uuid }}.{{ $field::class }}.item"
                    x-sortable-item="{{ $uuid }}"
                    {{ $attributes->merge($getExtraAttributes())->class([
                        'relative w-full',
                    ]) }}
                >
                    @if ($shouldDisplayAsList)
                        <div class="w-full flex items-center gap-4 text-xs pe-2">
                            <div class="curator-picker-list-preview flex-shrink-0 h-12 w-12 checkered">
                                @if (str($item['type'])->contains('image'))
                                    <img
                                        src="{{ $item['thumbnail_url'] }}"
                                        alt="{{ $item['alt'] ?? $item['name'] }}"
                                        @if ($shouldLazyLoad())
                                            loading="lazy"
                                        @endif
                                        @class([
                                           'h-full',
                                           'object-contain' => $isConstrained(),
                                           'object-cover w-full' => ! $isConstrained(),
                                       ])
                                    />
                                @else
                                    <x-curator::document-image
                                        label="{{ $item['name'] }}"
                                        type="{{ $item['type'] }}"
                                        extension="{{ $item['ext'] }}"
                                        icon-size="md"
                                    />
                                @endif
                            </div>
                            <div class="curator-picker-list-details min-w-0 overflow-hidden py-2">
                                <p>{{ $item['pretty_name'] }}</p>
                            </div>
                            <div class="curator-picker-list-details flex-shrink-0 ml-auto py-2">
                                <p>{{ $item['size_for_humans'] }}</p>
                            </div>
                            <div class="curator-picker-list-actions flex-shrink-0">
                                <div class="relative flex items-center">
                                    @if ($isMultiple)
                                        <div
                                            x-sortable-handle
                                            class="flex items-center justify-center flex-none w-8 h-8 transition text-gray-400 hover:text-gray-300"
                                        >
                                            {{ $getAction('reorder') }}
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-center flex-none w-8 h-8">
                                        <x-filament-actions::group
                                            :actions="[
                                                $getAction('view')(['url' => $item['url']]),
                                                $getAction('edit')(['id' => $item['id']]),
                                                $getAction('download')(['uuid' => $uuid]),
                                                $getAction('remove')(['uuid' => $uuid]),
                                            ]"
                                            color="gray"
                                            size="xs"
                                            dropdown-placement="bottom-end"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            @class([
                                'relative block w-full overflow-hidden border border-gray-300 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white flex justify-center checkered',
                                'h-64' => ! str($item['type'])->contains('video'),
                                'md:flex-1 ' => $itemsCount <= 3,
                            ])
                        >
                        @if (str($item['type'])->contains('image'))
                            <img
                                src="{{ $item['large_url'] }}"
                                alt="{{ $item['alt'] ?? $item['name'] }}"
                                @if ($shouldLazyLoad())
                                    loading="lazy"
                                @endif
                                @class([
                                   'h-full',
                                   'object-contain' => $isConstrained(),
                                   'object-cover w-full' => ! $isConstrained(),
                               ])
                            />
                        @elseif (str($item['type'])->contains('video'))
                            <video
                                controls
                                src="{{ $item['url'] }}"
                                @if ($shouldLazyLoad())
                                    preload="none"
                                @endif
                            ></video>
                        @else
                            <x-curator::document-image
                                label="{{ $item['name'] }}"
                                icon-size="xl"
                                type="{{ $item['type'] }}"
                                extension="{{ $item['ext'] }}"
                            />
                        @endif

                        <div class="absolute top-0 right-0">
                            <div class="relative flex items-center bg-gray-950 divide-x divide-gray-700 rounded-bl-lg shadow-md">
                                @if ($isMultiple)
                                    <div
                                        x-sortable-handle
                                        class="flex items-center justify-center flex-none w-10 h-10 transition text-gray-400 hover:text-gray-300"
                                    >
                                        {{ $getAction('reorder') }}
                                    </div>
                                @endif

                                <div class="flex items-center justify-center flex-none w-10 h-10">
                                    <x-filament-actions::group
                                        :actions="[
                                            $getAction('view')(['url' => $item['url']]),
                                            $getAction('edit')(['id' => $item['id']]),
                                            $getAction('download')(['uuid' => $uuid]),
                                            $getAction('remove')(['uuid' => $uuid]),
                                        ]"
                                        color="gray"
                                        size="xs"
                                        dropdown-placement="bottom-end"
                                    />
                                </div>
                            </div>
                        </div>

                        @if (! str($item['type'])->contains('video'))
                            <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-2 pt-10 pb-1 text-xs text-white bg-gradient-to-t from-black/80 to-transparent gap-3">
                                <p class="truncate">{{ $item['pretty_name'] }}</p>
                                <p class="flex-shrink-0">{{ $item['size_for_humans'] }}</p>
                            </div>
                        @endif
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        {{-- Placeholder estetik saat belum ada media (khusus picker tunggal) --}}
        @if ($itemsCount === 0 && ! $isMultiple)
            <div class="curator-empty-state flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center transition hover:border-primary-400 hover:bg-primary-50/40 dark:border-gray-600 dark:bg-white/5 dark:hover:border-primary-500">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-500/20 dark:text-primary-400">
                    <x-filament::icon icon="heroicon-o-photo" class="h-6 w-6" />
                </div>
                <div class="space-y-0.5">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Belum ada cover dipilih</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Pilih gambar dari galeri media atau unggah baru</p>
                </div>
                {{ $getAction('open_curator_picker') }}
            </div>
        @else
            <div
                @class([
                    'flex flex-wrap items-center gap-3',
                    'mt-4' => $itemsCount > 0,
                ])
            >
                {{-- Tombol pilih/ganti media selalu tampil untuk picker tunggal, atau selama belum melewati maxItems untuk picker multiple --}}
                @if (! $isMultiple || ! $maxItems || $itemsCount < $maxItems)
                    {{ $getAction('open_curator_picker') }}
                    @if (! $isMultiple && $itemsCount > 0)
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            Klik untuk mengganti cover saat ini
                        </span>
                    @endif
                @endif
                @if ($itemsCount > 1)
                    {{ $getAction('removeAll') }}
                @endif
            </div>
        @endif
    </div>
</x-dynamic-component>
