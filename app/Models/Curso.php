<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'curso';
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'precio',
        'descuento',
        'categoria_id',
        'docente_id'
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
}
