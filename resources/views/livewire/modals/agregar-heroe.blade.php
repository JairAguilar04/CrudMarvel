<x-modal>
    <x-slot name="title">
        {{-- condicionamos el titulo dependiendo a la accion que se realice --}}
        @if ($accion == 1 || $accion == 2)
            Agregar heroe
        @else
            Editar heroe
        @endif
    </x-slot>

    {{-- formulario --}}
    <x-slot name="formAction">
        {{ $formAction }}
        <x-slot name="content">
            <div class="flex flex-col gap-y-5">
                {{-- imagen --}}
                <div>
                    @if ($accion == 1 || $accion == 3)
                        <div>
                            <img src="{{ Str::contains($imagen, 'http://') ? $imagen : Storage::url($imagen) }}"
                                alt="{{ $nombre }}" class="w-full h-72 rounded-lg">
                            @if ($accion == 3)
                                <div class="flex flex-row justify-end items-center gap-x-3 mt-2">
                                    <input type="checkbox" name="updateImagen" id="updateImagen"
                                        wire:model.live="updateImagen">
                                    <label for="updateImagen">Editar imagen</label>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if ($accion == 2 || ($accion == 3 && $updateImagen != 0))
                        <div class="relative">
                            <label for="imagen">
                                Imagen<span class="font-bold text-red-600">*</span>
                            </label>
                            <div class="flex flex-row items-center">
                                <div>
                                    <input type="file" name="imagen" id="imagen" wire:model.live="imagen"
                                        accept=".jpg,.png" />
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
                                <div wire:click="limpiarArchivo()" class="absolute -right-2 button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" class="w-5 h-5">
                                        <path
                                            d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z" />
                                    </svg>
                                </div>
                                <p class="text-gray-800 sm:text-base text-sm pl-2 cursor-pointer">
                                    {{ $accion == 2 ? $imagen->getClientOriginalName() : $imagen }}
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
            <input type="text" name="nombre" id="nombre" wire:model.live="nombre" />
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
