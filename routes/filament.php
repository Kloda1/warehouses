<?php

use App\Filament\Resources\BillResource\Pages\AddBillItems;
use Illuminate\Support\Facades\Route;

Route::get('/admin/bills/{record}/items', [AddBillItems::class, '__invoke'])
    ->name('filament.admin.resources.bills.items');