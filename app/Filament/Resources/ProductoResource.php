<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Productos';
    
    protected static ?string $modelLabel = 'Producto';
    
    protected static ?string $pluralModelLabel = 'Productos';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('precio_inicial')
                    ->label('Precio Inicial')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('precio_venta')
                    ->label('Precio de Venta')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->disk('public')
                    ->directory('productos')
                    ->visibility('public')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cantidad_disponible')
                    ->label('Cantidad Disponible')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession()
            ->selectCurrentPageOnly(false)
            ->deselectAllRecordsWhenFiltered(false)
            ->selectable()
            ->recordAction(null)
            ->recordUrl(null)
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->disk('public')
                    ->size(60)
                    ->circular(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-cube'),
                Tables\Columns\TextColumn::make('precio_venta')
                    ->label('Precio de Venta')
                    ->money('USD')
                    ->sortable()
                    ->color('success')
                    ->weight('semibold')
                    ->icon('heroicon-m-currency-dollar'),
                Tables\Columns\TextColumn::make('cantidad_disponible')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state > 10 => 'success',
                        $state > 5 => 'warning',
                        default => 'danger',
                    })
                    ->icon('heroicon-m-archive-box'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-m-calendar'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('agregar_a_venta')
                    ->label('Agregar a Venta')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('success')
                    ->action(function ($record) {
                        return redirect()->to('/admin/ventas/create?productos=' . $record->id);
                    }),
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->icon('heroicon-m-eye')
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-m-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('exportar_seleccionados')
                        ->label('Exportar Seleccionados')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('info')
                        ->action(function ($records) {
                            // Lógica de exportación
                        }),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar Seleccionados')
                        ->icon('heroicon-m-trash')
                        ->color('danger'),
                    Tables\Actions\BulkAction::make('crear_venta')
                        ->label('Crear Venta con Seleccionados')
                        ->icon('heroicon-o-shopping-cart')
                        ->color('success')
                        ->action(function ($records) {
                            $productosIds = $records->pluck('id')->toArray();
                            return redirect()->to('/admin/ventas/create?productos=' . implode(',', $productosIds));
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Crear Venta')
                        ->modalDescription('¿Deseas crear una nueva venta con los productos seleccionados?')
                        ->modalSubmitActionLabel('Crear Venta')
                        ->modalIcon('heroicon-o-shopping-cart'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
