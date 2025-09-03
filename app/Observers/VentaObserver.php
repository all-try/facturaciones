<?php

namespace App\Observers;

use App\Models\Venta;
use App\Models\Producto;

class VentaObserver
{
    /**
     * Handle the Venta "created" event.
     */
    public function created(Venta $venta): void
    {
        // La reducción de stock se maneja en CreateVenta y EditVenta
        // para tener mejor control sobre el timing
    }

    /**
     * Handle the Venta "updated" event.
     */
    public function updated(Venta $venta): void
    {
        // La lógica de actualización de stock se maneja en EditVenta
        // para tener mejor control sobre los cambios
    }

    /**
     * Handle the Venta "deleted" event.
     */
    public function deleted(Venta $venta): void
    {
        // Restaurar stock de productos cuando se elimina una venta
        foreach ($venta->productos as $producto) {
            $producto->increment('cantidad_disponible', $producto->pivot->cantidad);
        }
    }

    /**
     * Handle the Venta "restored" event.
     */
    public function restored(Venta $venta): void
    {
        //
    }

    /**
     * Handle the Venta "force deleted" event.
     */
    public function forceDeleted(Venta $venta): void
    {
        //
    }
}
