<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    

    public function usuario()
    {
        return $this->morphOne(User::class, 'perfil');
    }
}
