<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Filament\Traits\HasResourceConfiguration;
use App\Models\Venta;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Get;
use Filament\Forms\Set;

class VentaResource extends Resource
{
    use HasResourceConfiguration;
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'Ventas';
    
    protected static ?string $modelLabel = 'Venta';
    
    protected static ?string $pluralModelLabel = 'Ventas';
    
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Si es vendedor, solo mostrar sus propias ventas
        if (Auth::user()?->isVendedor()) {
            $query->where('user_id', Auth::id());
        }
        
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('fecha')
                    ->label('Fecha')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('cliente_nombre')
                    ->label('Nombre del Cliente'),
                Forms\Components\TextInput::make('cliente_telefono')
                    ->label('Teléfono del Cliente')
                    ->tel(),
                Forms\Components\TextInput::make('vendedor_nombre')
                    ->label('Vendedor')
                    ->default(Auth::user()?->name ?? 'Usuario no identificado')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                Forms\Components\Repeater::make('productos')
                    ->schema([
                        Forms\Components\Select::make('producto_id')
                            ->label('Producto')
                            ->options(Producto::pluck('nombre', 'id'))
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state) {
                                    $producto = Producto::find($state);
                                    if ($producto) {
                                        $set('precio_unitario', $producto->precio_venta);
                                        $set('subtotal', $producto->precio_venta);
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('cantidad')
                            ->label('Cantidad')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $precio = $get('precio_unitario') ?? 0;
                                $cantidad = $get('cantidad') ?? 1;
                                $set('subtotal', $precio * $cantidad);
                            }),
                        Forms\Components\TextInput::make('precio_unitario')
                            ->label('Precio Unitario')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $precio = $get('precio_unitario') ?? 0;
                                $cantidad = $get('cantidad') ?? 1;
                                $set('subtotal', $precio * $cantidad);
                            }),
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->addActionLabel('Agregar Producto')
                    ->defaultItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-hashtag'),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable()
                    ->icon('heroicon-m-calendar-days')
                    ->color('info'),
                Tables\Columns\TextColumn::make('cliente_nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->weight('semibold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('productos_count')
                    ->label('Productos')
                    ->counts('productos')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-cube'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('USD')
                    ->sortable()
                    ->icon('heroicon-m-currency-dollar')
                    ->weight('bold')
                    ->color('success'),
                ...static::getTimestampColumns(),
            ])
            ->filters([
                Tables\Filters\Filter::make('fecha')
                    ->label('Filtrar por Fecha')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde')
                            ->label('Fecha Desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                            ->label('Fecha Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date),
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->icon('heroicon-m-eye')
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->visible(fn ($record) => Auth::user()?->isAdmin() || $record->user_id === Auth::id()),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->visible(fn ($record) => Auth::user()?->isAdmin() || $record->user_id === Auth::id()),
                Tables\Actions\Action::make('pdf')
                    ->label('Generar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn ($record) => route('venta.pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar Seleccionados')
                        ->icon('heroicon-m-trash')
                        ->color('danger'),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(3)
                    ->schema([
                        // Card de Información de Venta
                        Section::make('Información de Venta')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextEntry::make('fecha')
                                    ->label('Fecha')
                                    ->icon('heroicon-o-calendar-days')
                                    ->date('d/m/Y')
                                    ->color('primary')
                                    ->weight('bold'),
                                TextEntry::make('total')
                                    ->label('Total')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->money('USD')
                                    ->color('success')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->badge(),
                            ])
                            ->compact()
                            ->columnSpan(1),
                        
                        // Card de Información del Cliente
                        Section::make('Información del Cliente')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('cliente_nombre')
                                    ->label('Nombre')
                                    ->icon('heroicon-o-identification')
                                    ->color('success')
                                    ->copyable()
                                    ->copyMessage('Nombre copiado')
                                    ->weight('semibold'),
                                TextEntry::make('cliente_telefono')
                                    ->label('Teléfono')
                                    ->icon('heroicon-o-phone')
                                    ->color('info')
                                    ->copyable()
                                    ->copyMessage('Teléfono copiado')
                                    ->formatStateUsing(fn ($state) => $state ? '+' . $state : 'No registrado'),
                            ])
                            ->compact()
                            ->columnSpan(1),
                        
                        // Card de Información del Vendedor
                        Section::make('Información del Vendedor')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Vendedor')
                                    ->icon('heroicon-o-briefcase')
                                    ->color('warning')
                                    ->badge()
                                    ->weight('bold'),
                                TextEntry::make('created_at')
                                    ->label('Fecha de Registro')
                                    ->icon('heroicon-o-clock')
                                    ->dateTime('d/m/Y H:i')
                                    ->color('gray'),
                            ])
                            ->compact()
                            ->columnSpan(1),
                    ]),
                
                // Tabla de Productos
                Section::make('Productos Vendidos')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        TextEntry::make('productos')
                            ->label('')
                            ->formatStateUsing(function ($state, $record) {
                                $productos = $record->productos;
                                if (!$productos || $productos->isEmpty()) {
                                    return 'No hay productos en esta venta';
                                }
                                
                                $html = '<div class="space-y-4">';
                                foreach ($productos as $producto) {
                                    $html .= '<div class="border border-gray-200 rounded-lg p-4 bg-gray-50">';
                                    $html .= '<div class="grid grid-cols-1 md:grid-cols-4 gap-4">';
                                    
                                    // Producto
                                    $html .= '<div>';
                                    $html .= '<div class="text-sm font-medium text-gray-500 mb-1">Producto</div>';
                                    $html .= '<div class="font-semibold text-primary-600">' . e($producto->nombre) . '</div>';
                                    if ($producto->descripcion) {
                                        $html .= '<div class="text-sm text-gray-500 mt-1">' . e(Str::limit($producto->descripcion, 50)) . '</div>';
                                    }
                                    $html .= '</div>';
                                    
                                    // Cantidad
                                    $html .= '<div>';
                                    $html .= '<div class="text-sm font-medium text-gray-500 mb-1">Cantidad</div>';
                                    $html .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">';
                                    $html .= $producto->pivot->cantidad . ' unidades';
                                    $html .= '</span>';
                                    $html .= '</div>';
                                    
                                    // Precio Unitario
                                    $html .= '<div>';
                                    $html .= '<div class="text-sm font-medium text-gray-500 mb-1">Precio Unitario</div>';
                                    $html .= '<div class="text-green-600 font-medium">$' . number_format($producto->pivot->precio_unitario, 2) . '</div>';
                                    $html .= '</div>';
                                    
                                    // Subtotal
                                    $html .= '<div>';
                                    $html .= '<div class="text-sm font-medium text-gray-500 mb-1">Subtotal</div>';
                                    $html .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">';
                                    $html .= '$' . number_format($producto->pivot->subtotal, 2);
                                    $html .= '</span>';
                                    $html .= '</div>';
                                    
                                    $html .= '</div>';
                                    $html .= '</div>';
                                }
                                $html .= '</div>';
                                
                                // Resumen
                                $totalProductos = $productos->count();
                                $totalUnidades = $productos->sum('pivot.cantidad');
                                $html .= '<div class="mt-4 pt-4 border-t border-gray-200 flex justify-between text-sm">';
                                $html .= '<span class="text-gray-600">Total de productos: ' . $totalProductos . '</span>';
                                $html .= '<span class="text-gray-600">Total de unidades: ' . $totalUnidades . '</span>';
                                $html .= '</div>';
                                
                                return $html;
                            })
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan('full')
                    ->collapsible(),
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
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'view' => Pages\ViewVenta::route('/{record}'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
