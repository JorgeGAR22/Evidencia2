<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Las columnas que pueden ser llenadas masivamente
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    // Relación: Una nota pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}