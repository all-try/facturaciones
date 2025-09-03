<?php

use Illuminate\Support\Facades\Route;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/venta/{venta}/pdf', function (Venta $venta) {
    $pdf = Pdf::loadView('factura', ['venta' => $venta]);
    return $pdf->stream('factura-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT) . '.pdf');
})->name('venta.pdf');
