<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Models\Producto;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class EditVenta extends EditRecord
{
    protected static string $resource = VentaResource::class;
    
    public function mount(int | string $record): void
    {
        parent::mount($record);
        
        // Verificar si el vendedor puede editar esta venta
        if (Auth::user()?->isVendedor() && $this->record->user_id !== Auth::id()) {
            Notification::make()
                ->title('Acceso denegado')
                ->body('Solo puedes editar tus propias ventas.')
                ->danger()
                ->send();
            
            $this->redirect(VentaResource::getUrl('index'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cargar los productos existentes de la venta
        $venta = $this->record;
        $productos = [];
        
        foreach ($venta->productos as $producto) {
            $productos[] = [
                'producto_id' => $producto->id,
                'cantidad' => $producto->pivot->cantidad,
                'precio_unitario' => $producto->pivot->precio_unitario,
                'subtotal' => $producto->pivot->subtotal
            ];
        }
        
        $data['productos'] = $productos;
        
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Extraer productos del array de datos
        $productos = $data['productos'] ?? [];
        unset($data['productos']);
        
        // Manejar stock manualmente para actualizaciones
        // Primero restaurar stock de productos anteriores
        foreach ($record->productos as $productoAnterior) {
            $productoModel = Producto::find($productoAnterior->id);
            if ($productoModel) {
                $productoModel->increment('cantidad_disponible', $productoAnterior->pivot->cantidad);
            }
        }
        
        // Calcular el total
        $total = 0;
        foreach ($productos as $producto) {
            $total += ($producto['precio_unitario'] ?? 0) * ($producto['cantidad'] ?? 0);
        }
        $data['total'] = $total;
        
        // Actualizar la venta
        $record->update($data);
        
        // Sincronizar productos y reducir stock de los nuevos
        $productosParaSync = [];
        foreach ($productos as $producto) {
            $productosParaSync[$producto['producto_id']] = [
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => ($producto['precio_unitario'] ?? 0) * ($producto['cantidad'] ?? 0)
            ];
        }
        
        $record->productos()->sync($productosParaSync);
        
        // Reducir stock de los nuevos productos
        foreach ($productos as $producto) {
            $productoModel = Producto::find($producto['producto_id']);
            if ($productoModel) {
                $productoModel->decrement('cantidad_disponible', $producto['cantidad']);
            }
        }
        
        return $record;
    }
}
