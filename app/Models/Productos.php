<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $fillable = [
        'Nombre', 'Descripcion', 'Foto'
    ];
    protected $table = 'productos';

}
