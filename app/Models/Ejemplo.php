<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejemplo extends Model
{
    use HasFactory;
    protected $table = 'ejemplo';
    protected $fillable = [
        'contenido_texto',
        'contenido_video',
        'contenido_imagen',
        'contenido_audio',
        'tema_id'
    ];
    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }
}
