<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rol_permiso extends Model
{
    protected $table ='rol_permisos';
    protected $fillable = [
        'rol_id',
        'permiso_id'
    ];
}
