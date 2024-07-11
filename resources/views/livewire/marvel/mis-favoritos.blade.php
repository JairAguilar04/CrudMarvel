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



                    {{-- alerta de registro creado o actualizado --}}
                    @session('success')
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
                        <input type="text" name="buscador" id="buscador" wire:model.live="search"
                            class="ps-10 p-2.5 pr-14" placeholder="Buscador">
                        <div class="absolute -top-1 -right-4">
                            {{-- agregar un nuevo registro --}}
                            <button
                                onclick="Livewire.dispatch('openModal', { component: 'modals.agregar-heroe', arguments: { formAction: 'save', accion: 2 }  })"
                                class="button" title="Agregar heroe">
                                <div>
                                    <?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"
                                        width="30px" height="30px">
                                        <path
                                            d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M21,16h-5v5 c0,0.553-0.448,1-1,1s-1-0.447-1-1v-5H9c-0.552,0-1-0.447-1-1s0.448-1,1-1h5V9c0-0.553,0.448-1,1-1s1,0.447,1,1v5h5 c0.552,0,1,0.447,1,1S21.552,16,21,16z" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                        <div class="absolute top-3 right-12">
                            {{-- limpiar el buscador --}}
                            @if (!empty($search))
                                <button type="button" wire:click="limpiarBuscador()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" class="w-5 h-5">
                                        <path
                                            d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                        {{-- icono search --}}
                        <div class="absolute top-2 left-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" class="w-6 h-6">
                                <path
                                    d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z" />
                            </svg>
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
                                        {{-- mandamos a llamar el metodo para ordenar y le pasamos por parametro el nombre de la columna --}}
                                        <th class="w-[23%] cursor-pointer" wire:click="ordenarColumna('nombre')">
                                            Nombre<span class="pl-1 text-rojo-600 font-bold">&#8645;</span>
                                        </th>
                                        {{-- mandamos a llamar el metodo para ordenar y le pasamos por parametro el nombre de la columna --}}
                                        <th class="w-[25%] cursor-pointer" wire:click="ordenarColumna('descripcion')">
                                            Descripción<span class="pl-1 text-rojo-600 font-bold">&#8645;</span>
                                        </th>
                                        <th class="w-[15%]">Imagen</th>
                                        <th class="w-[7%] cursor-pointer" wire:click="ordenarColumna('updated_at')">
                                            Última modificación<span class="pl-1 text-rojo-600 font-bold">&#8645;</span>
                                        </th>
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
                                                <img src="{{ Str::contains($heroe->url_imagen, 'http://') ? $heroe->url_imagen : Storage::url($heroe->url_imagen) }}"
                                                    alt="{{ $heroe->nombre }}"
                                                    class="w-20 h-20 md:w-24 md:h-24 rounded-md sm:mx-auto mx-0 transision-card">

                                            </td>
                                            <td>{{ $heroe->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <button type="button"
                                                    wire:click="$dispatch('openModal', { component: 'modals.agregar-heroe', arguments: { id: {{ $heroe->id }}, idHeroe: {{ $heroe->id_heroe != 0 ? $heroe->id_heroe : 0 }}, nombre: '{{ $heroe->nombre }}', descripcion: '{{ $heroe->descripcion }}', imagen: '{{ $heroe->url_imagen }}', formAction: 'update', accion: 3 }})"
                                                    class="button button-primary">
                                                    Editar
                                                </button>
                                                <x-secondary-button {{-- llamamos al metodo para eliminar y le pasamos el id y el nombre como parametros --}}
                                                    @click="eliminarHeroe({{ $heroe->id }}, '{{ $heroe->nombre }}')">
                                                    Eliminar
                                                </x-secondary-button>
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
                                {{-- filas para ordenar --}}
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
                        {{-- si no hay ningun registro --}}
                        <div class="flex justify-center mt-10 text-azul-600 text-2xl font-bold">
                            No hay registros
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- ventana para confirmar la eliminacion --}}
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
