<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'telefono'
    ];
    public function usuario()
    {
        return $this->morphOne(User::class, 'perfil');
    }
}
