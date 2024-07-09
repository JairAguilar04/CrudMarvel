<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Mis personajes favoritos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">



                    {{-- alerta --}}
                    @session('success')
                        {{-- <div class="bg-red-600">
                            {{ Session::get('success') }}
                        </div> --}}
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                text: '{{ Session::get('success') }}',
                                iconColor: '#1c559d',
                                confirmButtonColor: '#ec1d24',
                                showConfirmButton: false,
                                timer: 2500
                            });
                        </script>
                    @endsession

                    {{-- buscador --}}
                    <div class="flex sm:w-3/4 mx-auto relative">
                        <input type="text" name="buscador" id="buscador" wire:model.live="search" class="w-full">
                        <div class="absolute top-2 right-2">
                            <button onclick="Livewire.dispatch('openModal', { component: 'modals.agregar-heroe' })">
                                Agregar heroe
                            </button>
                        </div>
                    </div>

                    {{-- registros obtenidos --}}
                    @if ($heroesFavoritos->first())
                        <div class="overflow-x-auto mt-8">
                            {{-- tabla de mis heroes --}}
                            <table class="w-full table-auto text-gray-800">
                                <thead>
                                    <tr>
                                        <th class="w-[5%]">No.</th>
                                        <th class="w-[25%] cursor-pointer" wire:click="ordenarColumna('nombre')">
                                            Nombre<span class="pl-1 text-rojo-600 font-bold">&#8645;</span>
                                        </th>
                                        <th class="w-[30%] cursor-pointer" wire:click="ordenarColumna('descripcion')">
                                            Descripción<span class="pl-1 text-rojo-600 font-bold">&#8645;</span>
                                        </th>
                                        <th class="w-[15%]">Imagen</th>
                                        <th class="w-[15%]">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($heroesFavoritos as $heroe)
                                        <tr class="border-b-gray-200 border-transparent">
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ $heroe->nombre }}</td>
                                            <td class="text-justify">{{ $heroe->descripcion }}</td>
                                            <td>
                                                <img src="{{ Storage::url($heroe->url_imagen) }}"
                                                    alt="{{ $heroe->nombre }}" class="w-24 h-24 rounded-md mx-auto">
                                            </td>
                                            <td>
                                                <x-secondary-button>Editar</x-secondary-button>
                                                {{-- <x-secondary-button
                                                    wire:click="delete({{ $heroe->id }})">Eliminar</x-secondary-button> --}}
                                                <x-secondary-button
                                                    @click="eliminarHeroe({{ $heroe->id }}, '{{ $heroe->nombre }}')">Eliminar</x-secondary-button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- paginador --}}
                        <div class="flex sm:flex-row flex-col items-center mt-10 ">
                            <div class="w-[85%]">
                                {{ $heroesFavoritos->links() }}
                            </div>
                            <div class="sm:w-1/5 sm:flex hidden justify-end items-center">
                                <label for="filas" class="mr-1">Filas:</label>
                                <select name="filas" id="filas" wire:model.live="filas" class="w-20">
                                    @for ($i = 5; $i <= 30; $i += 5)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    <option value="{{ $totalRegistros }}">all</option>
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-center mt-10 text-azul-600 text-2xl font-bold">
                            No hay registros
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function eliminarHeroe(id, nombre) {
            Swal.fire({
                text: "Estas seguro de eliminar al heroe " + nombre + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1c559d",
                cancelButtonColor: "#ec1d24",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete', {
                        id
                    })
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: 'Se elimino correctamente.',
                        iconColor: '#1c559d',
                        confirmButtonColor: '#ec1d24',
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            });
        }
    </script>
</div>
