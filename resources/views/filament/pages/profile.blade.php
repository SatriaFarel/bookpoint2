<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament::button type="submit" style="margin-top: 10px">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>