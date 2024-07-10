<?php

namespace App\Livewire\Marvel;

use App\Models\Heroes;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Str;

#[Layout('layouts.app')]

class MisFavoritos extends Component
{
    use WithPagination;

    public $columna = 'created_at'; //ordena por columna
    public $direccion = 'DESC'; // orden ASC o DESC
    public $search = '';
    public $filas = 5;
    public $totalRegistros;

    public $listeners = [
        'delete'
    ];

    public function render()
    {
        //llenamos la variable con todo lo que tenga el modelo Heroes
        $heroes = Heroes::select();

        $this->totalRegistros = $heroes->count();

        if (!empty($this->search)) { // si el buscador no esta vacio realizamos la busqueda
            $heroes = $heroes->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        //mandamos a la vista la variable -heroes-, ordenamos y paginamos
        return view(
            'livewire.marvel.mis-favoritos',
            ['heroesFavoritos' => $heroes->orderBy($this->columna, $this->direccion)->paginate($this->filas, pageName: 'heroes')]
        );
    }

    //metodo para eliminar un solo registro
    public function delete($id)
    {
        $heroe = Heroes::where('id', $id);
        $heroe->delete();
    }

    public function ordenarColumna($columna)
    {
        $this->columna = $columna;
        // si la direccion es ASC la pasamos a DESC, si es DESC la pasamos a ASC
        $this->direccion = $this->direccion == 'ASC' ? 'DESC' : 'ASC';
    }

    //actualiza el paginador para que no se pierdan los resultados
    public function updatedSearch()
    {
        $this->resetPage(pageName: 'heroes');
    }

    public function limpiarBuscador()
    {
        $this->search = '';
    }
}
