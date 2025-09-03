<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $fillable = [
        'fecha',
        'total',
        'cliente_nombre',
        'cliente_telefono',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'venta_producto')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal')
            ->withTimestamps();
    }

    public function calcularTotal(): float
    {
        return $this->productos()->sum('venta_producto.subtotal');
    }

    /**
     * Relación con el usuario (vendedor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el nombre del vendedor
     */
    public function getVendedorNombreAttribute(): string
    {
        return $this->user ? $this->user->name : 'Sin asignar';
    }
}
