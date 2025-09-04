<?php

namespace App\Filament\Traits;

use Filament\Tables\Table;

trait HasResourceConfiguration
{
    /**
     * Configuración común para tablas de recursos
     */
    protected static function configureTable(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession()
            ->selectCurrentPageOnly(false)
            ->deselectAllRecordsWhenFiltered(false)
            ->selectable();
    }

    /**
     * Configuración de colores para badges de estado
     */
    protected static function getStatusColors(): array
    {
        return [
            'success' => 'success',
            'warning' => 'warning', 
            'danger' => 'danger',
            'info' => 'info',
            'gray' => 'gray',
        ];
    }

    /**
     * Configuración de iconos comunes
     */
    protected static function getCommonIcons(): array
    {
        return [
            'view' => 'heroicon-m-eye',
            'edit' => 'heroicon-m-pencil-square',
            'delete' => 'heroicon-m-trash',
            'create' => 'heroicon-m-plus',
            'calendar' => 'heroicon-m-calendar',
            'user' => 'heroicon-m-user',
            'currency' => 'heroicon-m-currency-dollar',
            'archive' => 'heroicon-m-archive-box',
        ];
    }

    /**
     * Configuración de acciones comunes para tablas
     */
    protected static function getCommonTableActions(): array
    {
        $icons = static::getCommonIcons();
        
        return [
            \Filament\Tables\Actions\ViewAction::make()
                ->label('Ver')
                ->icon($icons['view'])
                ->color('info'),
            \Filament\Tables\Actions\EditAction::make()
                ->label('Editar')
                ->icon($icons['edit'])
                ->color('warning'),
            \Filament\Tables\Actions\DeleteAction::make()
                ->label('Eliminar')
                ->icon($icons['delete'])
                ->color('danger'),
        ];
    }

    /**
     * Configuración de acciones masivas comunes
     */
    protected static function getCommonBulkActions(): array
    {
        return [
            \Filament\Tables\Actions\BulkActionGroup::make([
                \Filament\Tables\Actions\DeleteBulkAction::make()
                    ->label('Eliminar Seleccionados')
                    ->icon('heroicon-m-trash')
                    ->color('danger'),
            ]),
        ];
    }

    /**
     * Configuración de columnas de timestamps comunes
     */
    protected static function getTimestampColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('created_at')
                ->label('Fecha de Creación')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->icon('heroicon-m-calendar'),
            \Filament\Tables\Columns\TextColumn::make('updated_at')
                ->label('Fecha de Actualización')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->icon('heroicon-m-calendar'),
        ];
    }
}