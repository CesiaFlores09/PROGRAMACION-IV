<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MascotaActual extends Model
{
    use HasFactory;

    protected $fillable = ['idUsuario', 'idMascota'];

    public $incrementing = false;
}
