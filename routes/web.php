<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(
    [
        'auth:sanctum',
        'role:admin',
        config('jetstream.auth_session', 'verified'),
        'verified',
    ]
)->group(function () {
    Route::get('/dashboard', \App\Livewire\Wms\Dashboard\Index::class)->name('dashboard');
});

Route::middleware(
    [
        'auth:sanctum',
        'role:admin',
        config('jetstream.auth_session', 'verified'),
        'verified',
        'session_validated',
    ]
)
    ->prefix('/wms/master')
    ->group(function () {
        Route::get('/supplier', \App\Livewire\Wms\Master\Supplier\Index::class)->name('supplier');
        Route::get('/customer', \App\Livewire\Wms\Master\Customer\Index::class)->name('customer');
        Route::get('/category', \App\Livewire\Wms\Master\Category\Index::class)->name('category');
        Route::get('/item', \App\Livewire\Wms\Master\Item\Index::class)->name('item');
        Route::get('/item/create', \App\Livewire\Wms\Master\Item\Form::class)->name('item-create');
        Route::get('/transporter', \App\Livewire\Wms\Master\Transporter\Index::class)->name('transporter');
        Route::get('/truck-size', \App\Livewire\Wms\Master\TruckSize\Index::class)->name('truck-size');
        Route::get('/warehouse', \App\Livewire\Wms\Master\Warehouse\Index::class)->name('warehouse');
    });


Route::middleware(
    [
        'auth:sanctum',
        'role:admin',
        config('jetstream.auth_session', 'verified'),
        'verified',
        'session_validated',
    ]
)
    ->prefix('/wms/receiving')
    ->group(function () {
        Route::get('/inbound', \App\Livewire\Wms\Transaction\Inbound\Index::class)->name('inbound');
        Route::get('/inbound/create', \App\Livewire\Wms\Transaction\Inbound\Form::class)->name('inbound-create');
    });

Route::middleware(
    [
        'auth:sanctum',
        'role:admin',
        config('jetstream.auth_session', 'verified'),
        'verified',
        'session_validated',
    ]
)
    ->prefix('/wms/shipment')
    ->group(function () {
        Route::get('/outbound', \App\Livewire\Wms\Transaction\Outbound\Index::class)->name('outbound');
        Route::get('/outbound/create', \App\Livewire\Wms\Transaction\Outbound\Form::class)->name('outbound-create');
    });


Route::middleware(
    [
        'auth:sanctum',
        'role:admin',
        config('jetstream.auth_session', 'verified'),
        'verified',
        'session_validated',
    ]
)
    ->prefix('/wms/inventory')
    ->group(function () {
        Route::get('/stock', \App\Livewire\Wms\Inventory\Stock::class)->name('inventory-stock');
    });




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', \App\Livewire\Wms\Dashboard\Index::class)->name('dashboard');
    Route::get('/home', \App\Livewire\Home\Index::class)->name('home');
    Route::get('/post', \App\Livewire\Post\Index::class)->name('post');
    Route::get('/shop', \App\Livewire\Shop\Index::class)->name('shop');
    Route::get('/detail', \App\Livewire\Shop\ProductDetail\Index::class)->name('shop.detail');
    Route::get('/checkout', \App\Livewire\Shop\Checkout\Index::class)->name('shop.checkout');
    Route::get('/product', \App\Livewire\Product\Index::class)->name('product');
    Route::get('/good-receipt', \App\Livewire\GoodReceive\Index::class)->name('good-receipt');
    Route::get('/inventory', \App\Livewire\Inventory\Index::class)->name('inventory');
});
