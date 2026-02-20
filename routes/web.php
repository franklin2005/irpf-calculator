<?php

use App\Livewire\Irpf\IrpfCalculatorPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ui', function () {
    return view('ui');
});

Route::get('/calculadora-irpf/{year}', IrpfCalculatorPage::class)
    ->whereNumber('year')
    ->where('year', '2026')
    ->name('irpf.calculator');
