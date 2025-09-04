<?php

namespace App\Filament\Widgets;

use App\Models\Venta;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class VentasPorMesChart extends ChartWidget
{
    protected static ?string $heading = 'Ventas por Mes';
    protected static ?string $description = 'Evolución de las ventas en los últimos 12 meses';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Obtener datos de los últimos 12 meses
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->locale('es')->format('M Y');
            $labels[] = $monthName;
            
            $totalVentas = Venta::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            
            $data[] = (float) $totalVentas;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Ventas ($)',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "$" + value.toLocaleString(); }',
                    ],
                ],
            ],
        ];
    }
}
