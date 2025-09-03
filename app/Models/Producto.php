<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_inicial',
        'precio_venta',
        'imagen',
        'cantidad_disponible',
    ];

    protected $casts = [
        'precio_inicial' => 'decimal:2',
        'precio_venta' => 'decimal:2',
    ];

    public function ventas(): BelongsToMany
    {
        return $this->belongsToMany(Venta::class, 'venta_producto')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal')
            ->withTimestamps();
    }
}
