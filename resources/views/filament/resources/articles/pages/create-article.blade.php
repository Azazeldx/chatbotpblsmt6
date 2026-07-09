<div>
    <x-filament-panels::page
        @class([
            'fi-resource-create-record-page',
            'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        ])
    >
        <x-filament-panels::form
            id="form"
            :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
            wire:submit="create"
        >
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>

        <x-filament-panels::page.unsaved-data-changes-alert />
    </x-filament-panels::page>

    {{-- Chatbot widget di dashboard admin dinonaktifkan (dianggap tidak berguna di sini).
         Hapus tanda komentar di bawah untuk mengaktifkannya kembali. --}}
    {{-- @if (config('general-settings.features.ai', false))
        @livewire('chatbot-widget')
    @endif --}}
</div>
