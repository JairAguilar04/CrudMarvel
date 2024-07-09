<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Personajes') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- alerta --}}
                    @session('errorDB')
                        <div class="bg-red-600">
                            {{ Session::get('errorDB') }}
                        </div>
                    @endsession
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5 mt-2">
                        @foreach ($heroes as $heroe)
                            {{-- card heroes --}}
                            <div class="flex flex-col gap-y-4 p-5 rounded-md bg-rojo-600 button-card hover:bg-azul-600">

                                {{-- imagen --}}
                                <div>
                                    <img src="{{ $heroe['thumbnail']['path'] . '.' . $heroe['thumbnail']['extension'] }}"
                                        alt="{{ $heroe['name'] }}" class="w-full h-72 rounded-md bg-blue-400">
                                </div>

                                {{-- funcionalidad --}}
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-white">{{ $heroe['name'] }}</p>
                                    <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'modals.agregar-heroe', arguments: { idHeroe: {{ $heroe['id'] }},
                                        nombre: '{{ $heroe['name'] }}', descripcion: '{{ Str::replace("'", '', $heroe['description']) }}',
                                        imagen: '{{ $heroe['thumbnail']['path'] . '.' . $heroe['thumbnail']['extension'] }}', accion: 1 }})"
                                        class="button bg-gray-300 text-gray-800">Ver</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
