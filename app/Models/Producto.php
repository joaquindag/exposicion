<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable=['nombre', 'descripcion', 'precio'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'users_productos',
            'producto_id',
            'user_id'
        );
    }
}
