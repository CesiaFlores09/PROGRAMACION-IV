<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCartillas extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCartilla',
        'idVacuna',
    ];

    public $incrementing = false;
}
