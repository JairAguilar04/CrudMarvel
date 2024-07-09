<?php

namespace App\Livewire\Modals;

use App\Models\Heroes;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;

class AgregarHeroe extends ModalComponent
{

    use WithFileUploads;

    public $idHeroe;

    #[Validate('required|max:100')]
    public $nombre;

    #[Validate('required|max:500')]
    public $descripcion;

    #[Validate('required|max:1024')] // 1MB max
    public $imagen;

    public $formAction = "save";
    public $accion;

    /**
     * accion = 1, inserta desde la API
     * accion = 2, inserta nuevo heroe
     * accion = 3, editar
     */

    //  mensajes de validaciones
    protected $messages = [
        'nombre.required' => 'El nombre del heroe no puede estar vacío.',
        'nombre.max' => 'El nombre es demasiado largo.',
        'descripcion.required' => 'La descripción del heroe no puede estar vacía.',
        'descripcion.max' => 'La descripción del heroe es demasiado larga.',
        'imagen.required' => 'La imagen no puede estar vacía.',
        'imagen.max' => 'La ruta de la imagen es demasiado larga.',
        'idHeroe.required' => 'El id no esta vacío.',
        'idHeroe.unique' => 'Este heroe ya esta en la tabla de tus favoritos.',
    ];

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.modals.agregar-heroe');
    }

    public function save()
    {
        $this->validate();

        if ($this->accion == 1) {
            $this->validate(
                ['idHeroe' => 'required|unique:heroes,id_heroe']
            );
        } else {
            $this->idHeroe = null;

            //guardamos la imagen el el sistema de archivos
            $rutaImagen = "public/imagenes/";
            $nombreImagen = $this->imagen->getClientOriginalName();
            $this->imagen->storeAs($rutaImagen, $nombreImagen);

            $rutaCompleta = $rutaImagen . $nombreImagen;
            $this->imagen = $rutaCompleta;
        }


        DB::beginTransaction();
        try {
            //creamos un objeto de tipo Heroe
            $heroe = new Heroes();
            $heroe->id_heroe = $this->idHeroe;
            $heroe->nombre = $this->nombre;
            $heroe->descripcion = $this->descripcion;
            $heroe->url_imagen = $this->imagen;
            $heroe->save();

            DB::commit();
            return redirect('/mis-heroes')->with('success', 'Tu personaje se guardo correctamente. ');
        } catch (\Exception $e) {
            // revierte los cambios y no almacena en DB
            DB::rollBack();
            return redirect()->back()->with('errorDB', 'Ocurrio un error al agregar su heroe' . $e->getMessage());
        }
    }
}
