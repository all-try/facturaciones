<?php

namespace App\Filament\Widgets;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Estadísticas de ventas
        $totalVentas = Venta::sum('total');
        $ventasHoy = Venta::whereDate('created_at', today())->sum('total');
        $ventasMes = Venta::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // Estadísticas de productos
        $totalProductos = Producto::count();
        $productosStockBajo = Producto::where('cantidad_disponible', '<=', 5)->count();
        
        // Estadísticas de usuarios
        $totalUsuarios = User::count();
        $vendedores = User::where('role', 'vendedor')->count();
        
        // Ventas del mes anterior para comparación
        $ventasMesAnterior = Venta::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');
        
        $crecimientoMensual = $ventasMesAnterior > 0 
            ? (($ventasMes - $ventasMesAnterior) / $ventasMesAnterior) * 100 
            : 0;
        
        return [
            Stat::make('Total de Ventas', '$' . number_format($totalVentas, 2))
                ->description('Ingresos totales acumulados')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            
            Stat::make('Ventas del Mes', '$' . number_format($ventasMes, 2))
                ->description($crecimientoMensual >= 0 
                    ? '+' . number_format($crecimientoMensual, 1) . '% vs mes anterior'
                    : number_format($crecimientoMensual, 1) . '% vs mes anterior')
                ->descriptionIcon($crecimientoMensual >= 0 
                    ? 'heroicon-m-arrow-trending-up' 
                    : 'heroicon-m-arrow-trending-down')
                ->color($crecimientoMensual >= 0 ? 'success' : 'danger')
                ->chart([3, 5, 8, 12, 15, 18, 20]),
            
            Stat::make('Ventas de Hoy', '$' . number_format($ventasHoy, 2))
                ->description('Ingresos del día actual')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info')
                ->chart([1, 3, 2, 5, 4, 6, 8]),
            
            Stat::make('Productos Disponibles', number_format($totalProductos))
                ->description($productosStockBajo . ' productos con stock bajo')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($productosStockBajo > 0 ? 'warning' : 'success')
                ->chart([10, 12, 8, 15, 13, 11, 14]),
            
            Stat::make('Usuarios Registrados', number_format($totalUsuarios))
                ->description($vendedores . ' vendedores activos')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([2, 3, 4, 5, 6, 7, 8]),
        ];
    }
}
