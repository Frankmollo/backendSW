<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    protected $table = 'curso';
    protected $fillable = [
        'titulo',
        'descripcion',
        'curso_id'
    ];
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
