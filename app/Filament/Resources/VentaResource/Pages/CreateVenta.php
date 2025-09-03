<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Models\Producto;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    public function mount(): void
    {
        parent::mount();
        
        // Si hay productos preseleccionados desde la URL
        $productosPreseleccionados = request()->get('productos');
        if ($productosPreseleccionados) {
            $productosIds = explode(',', $productosPreseleccionados);
            $productos = Producto::whereIn('id', $productosIds)->get();
            
            $productosData = [];
            foreach ($productos as $producto) {
                $productosData[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => 1,
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $producto->precio_venta
                ];
            }
            
            $this->form->fill([
                'productos' => $productosData
            ]);
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asegurar que se asigne el user_id del usuario autenticado
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Extraer productos del array de datos
        $productos = $data['productos'] ?? [];
        unset($data['productos']);
        
        // Calcular el total
        $total = 0;
        foreach ($productos as $producto) {
            $total += ($producto['precio_unitario'] ?? 0) * ($producto['cantidad'] ?? 0);
        }
        $data['total'] = $total;
        
        // Crear la venta
        $venta = static::getModel()::create($data);
        
        // Agregar productos a la venta
        foreach ($productos as $producto) {
            $venta->productos()->attach($producto['producto_id'], [
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => ($producto['precio_unitario'] ?? 0) * ($producto['cantidad'] ?? 0)
            ]);
            
            // Reducir stock del producto
            $productoModel = Producto::find($producto['producto_id']);
            if ($productoModel) {
                $productoModel->decrement('cantidad_disponible', $producto['cantidad']);
            }
        }
        
        return $venta;
    }
}
