<?php

namespace App\Livewire\Marvel;

use App\Models\Heroes;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]

class MisFavoritos extends Component
{
    use WithPagination;

    public $columna = 'created_at';
    public $direccion = 'DESC';
    public $search = '';
    public $filas = 5;
    public $totalRegistros;

    public $listeners = [
        'delete'
    ];


    public function render()
    {


        $heroes = Heroes::select();

        $this->totalRegistros = $heroes->count();
        //dd($this->totalRegistros);

        if (!empty($this->search)) {

            $heroes = $heroes->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        return view(
            'livewire.marvel.mis-favoritos',
            ['heroesFavoritos' => $heroes->orderBy($this->columna, $this->direccion)->paginate($this->filas, pageName: 'heroes')]
        );
    }

    public function delete($id)
    {
        $heroe = Heroes::where('id', $id);
        $heroe->delete();
    }

    public function ordenarColumna($columna)
    {
        $this->columna = $columna;
        $this->direccion = $this->direccion == 'ASC' ? 'DESC' : 'ASC';
    }

    public function updatedSearch()
    {
        $this->resetPage(pageName: 'heroes');
    }
}
