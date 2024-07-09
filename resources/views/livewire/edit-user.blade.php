<x-modal>
    <x-slot name="title">
        Nueva línea de generación y aplicación del conocimiento
    </x-slot>
    <x-slot name="content">
    </x-slot>
    <x-slot name="buttons">
        <button wire:click="save" class="btn-success button sm:w-auto w-full">
            Guardar
        </button>
        <button wire:click="$dispatch('closeModal')" class="btn-warning button sm:w-auto w-full">
            Cancelar
        </button>
    </x-slot>
</x-modal>
