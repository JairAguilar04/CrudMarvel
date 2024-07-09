<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heroes extends Model
{
    use HasFactory;

    protected $table = 'heroes';

    //campos a llenar
    public $fillable = [
        'id_heroe',
        'nombre',
        'descripcion',
        'url_imagen'
    ];
}
