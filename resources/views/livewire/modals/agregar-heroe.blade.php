<x-modal>
    <x-slot name="title">
        Agregar heroe
    </x-slot>

    {{-- formulario --}}
    <x-slot name="formAction">
        {{ $formAction }}
        <x-slot name="content">
            <div class="flex flex-col gap-y-5">
                {{-- imagen --}}
                <div>
                    @if ($accion == 1)
                        <div>
                            <img src="{{ $imagen }}" alt="{{ $nombre }}" class="w-full h-72 rounded-lg">
                        </div>
                    @else
                        <div>
                            <label for="imagen">
                                Imagen<span class="font-bold text-red-600">*</span>
                            </label>
                            <div class="flex flex-row items-center">
                                <div>
                                    <input type="file" name="imagen" id="imagen" wire:model.live="imagen">
                                </div>
                                <div
                                    class="bg-white h-10 flex items-center w-full border border-azul-600 border-l-transparent rounded-md rounded-l-none text-gray-800">
                                @empty($imagen)
                                    <label for="imagen"
                                        class="text-gray-800 sm:text-base text-sm pl-2 cursor-pointer">
                                        Sin archivos seleccionados.
                                    </label>
                                @endempty
                            @empty(!$imagen)
                                <p wire:click="" class="text-gray-800 sm:text-base text-sm pl-2 cursor-pointer">
                                    {{ $imagen->getClientOriginalName() }}
                                </p>
                            @endempty
                        </div>
                    </div>
                    <div wire:loading wire:target="imagen">
                        <span class="text-sm text-gray-700">Cargando imagen...</span>
                    </div>
                    <x-input-error :messages="$errors->get('imagen')" class="-mt-2" />
                </div>
            @endif
        </div>
        {{-- nombre --}}
        <div>
            <label for="nombre" class="label">
                Nombre<span class="font-bold text-red-600">*</span>
            </label>
            <input type="text" name="nombre" id="nombre" wire:model.live="nombre">
            <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
        </div>
        {{-- descripcion --}}
        <div>
            <label for="descripcion" class="label">
                Descripción<span class="font-bold text-red-600">*</span>
            </label>
            <textarea name="descripcion" id="descripcion" cols="30" rows="4" wire:model.live="descripcion"></textarea>
            <x-input-error :messages="$errors->get('descripcion')" class="mt-1" />
        </div>
        {{-- mensaje de error si el personaje ya esta en DB --}}
        <div>
            @error('idHeroe')
                <span
                    class="text-gray-900 font-bold bg-yellow-600 block p-2 border border-l-4 border-yellow-800">{{ $message }}</span>
            @enderror
        </div>



        {{-- <ul class="bg-red-500">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul> --}}


    </div>
</x-slot>
<x-slot name="buttons">
    <x-primary-button>
        Guardar
    </x-primary-button>
    <x-secondary-button wire:click="$dispatch('closeModal')">
        Cerrar
    </x-secondary-button>
</x-slot>
</x-slot>
</x-modal>
