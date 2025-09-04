<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProductosMasVendidosChart extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Productos Más Vendidos';
    protected static ?string $description = 'Productos con mayor cantidad de unidades vendidas';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        // Obtener los 10 productos más vendidos
        $productosVendidos = DB::table('venta_producto')
            ->join('productos', 'venta_producto.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(venta_producto.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($productosVendidos as $producto) {
            $labels[] = $producto->nombre;
            $data[] = (int) $producto->total_vendido;
        }
        
        // Si no hay datos, mostrar mensaje
        if (empty($data)) {
            $labels = ['Sin datos'];
            $data = [0];
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Unidades Vendidas',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(14, 165, 233, 0.8)',
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(139, 92, 246)',
                        'rgb(236, 72, 153)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(168, 85, 247)',
                        'rgb(14, 165, 233)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 45,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
