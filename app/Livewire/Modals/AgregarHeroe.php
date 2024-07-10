<?php

namespace App\Livewire\Modals;

use App\Models\Heroes;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AgregarHeroe extends ModalComponent
{

    use WithFileUploads;

    public $id;
    public $idHeroe;

    #[Validate('required|max:100')] //condiciones
    public $nombre;

    #[Validate('required|max:500')]
    public $descripcion;

    #[Validate('required|max:1024')] // 1MB max
    public $imagen;

    public $formAction; //funcionalida save o update
    public $accion;

    //no ayudara a saber si se va a actualizar la imagen 0 = no, 1 = si
    public $updateImagen = 0;
    public $fecha;

    /**
     * Variable accion
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
        'imagen.max' => 'La imagen es muy grande para almacenarce, solo admite 1 MB.',
        'imagen.mimes' => 'Solo puedes subir imagenes con extensión .jpg o .png',
        'imagen.unique' => 'La imagen ya existe, intente guardarla con otro nombre.',
        'idHeroe.required' => 'El id no esta vacío.',
        'idHeroe.unique' => 'Este heroe ya esta en la tabla de tus favoritos.',
    ];

    public function mount()
    {
        //inicializamos la variable fecha
        $this->fecha = Carbon::now();
        $this->fecha = $this->fecha->format('dmy-His');
    }

    public function render()
    {
        return view('livewire.modals.agregar-heroe');
    }

    // metodo para guardar
    public function save()
    {
        $this->validate();

        if ($this->accion == 1) { // el registro viene la API
            $this->validate(
                //valida que el registro no exista en DB
                ['idHeroe' => 'required|unique:heroes,id_heroe']
            );
        } else { // registro nuevo

            $this->idHeroe = null;
            $this->validate(
                ['imagen' => 'mimes:jpg,png']
            );

            $rutaImagen = "public/imagenes/";
            $nombreImagen = $this->fecha . '-' . $this->imagen->getClientOriginalName();
            //guardamos la imagen el el sistema de archivos
            $this->imagen->storeAs($rutaImagen, $nombreImagen);

            $rutaCompleta = $rutaImagen . $nombreImagen;
            $this->imagen = $rutaCompleta;
        }


        DB::beginTransaction();
        try {
            //creamos un objeto de tipo Heroe para almacenar en DB
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

    public function update()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $heroe = Heroes::find($this->id);
            $heroe->nombre = $this->nombre;
            $heroe->descripcion = $this->descripcion;

            if ($this->updateImagen != 0) { // si editara la imagen
                $rutaImagen = "public/imagenes/";
                $nombreImagen = $this->fecha . '-' . $this->imagen->getClientOriginalName();
                $this->imagen->storeAs($rutaImagen, $nombreImagen);

                $rutaCompleta = $rutaImagen . $nombreImagen;
                $this->imagen = $rutaCompleta;
                $heroe->url_imagen = $this->imagen;
            }

            $heroe->save();

            DB::commit();
            return redirect('/mis-heroes')->with('success', 'Tu personaje se edito correctamente. ');
        } catch (\Exception $e) {
            // revierte los cambios y no almacena en DB
            DB::rollBack();
            return redirect()->back()->with('errorDB', 'Ocurrio un error al editar su heroe' . $e->getMessage());
        }
    }

    public function limpiarArchivo()
    {
        $this->imagen = null;
    }
}
