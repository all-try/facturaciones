<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ViewVenta extends ViewRecord
{
    protected static string $resource = VentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => Auth::user()?->isAdmin() || $this->record->user_id === Auth::id()),
        ];
    }

    protected function resolveRecord($key): Model
    {
        return static::getResource()::resolveRecordRouteBinding($key)
            ->load(['productos', 'user']);
    }
}