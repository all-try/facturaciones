<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\ChartWidget;

class ProductosPorStockChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Productos por Stock';
    protected static ?string $description = 'Clasificación de productos según niveles de inventario';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Clasificar productos por niveles de stock
        $stockAlto = Producto::where('cantidad_disponible', '>', 20)->count();
        $stockMedio = Producto::whereBetween('cantidad_disponible', [6, 20])->count();
        $stockBajo = Producto::whereBetween('cantidad_disponible', [1, 5])->count();
        $sinStock = Producto::where('cantidad_disponible', 0)->count();
        
        return [
            'datasets' => [
                [
                    'data' => [$stockAlto, $stockMedio, $stockBajo, $sinStock],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',   // Verde para stock alto
                        'rgb(59, 130, 246)',  // Azul para stock medio
                        'rgb(245, 158, 11)',  // Amarillo para stock bajo
                        'rgb(239, 68, 68)',   // Rojo para sin stock
                    ],
                    'borderWidth' => 2,
                    'borderColor' => 'rgb(255, 255, 255)',
                ],
            ],
            'labels' => [
                'Stock Alto (>20)',
                'Stock Medio (6-20)',
                'Stock Bajo (1-5)',
                'Sin Stock (0)',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
