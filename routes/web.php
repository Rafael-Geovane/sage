<?php

use Illuminate\Support\Facades\Route;

Route::get('/styles.css', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    $css = preg_replace('/^\s*@import.*$/m', '', $css);
    $css = preg_replace('/^\s*@source.*$/m', '', $css);
    $css = preg_replace('/^\s*@theme\s*\{\s*/', '', $css);
    $css = preg_replace('/\}\s*$/', '', $css);

    return response($css, 200)
        ->header('Content-Type', 'text/css');
});

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/admin', function() {
    return view('admin');
})->name('admin');

Route::get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard');

Route::get('/loja', function() {
    return view('loja');
})->name('loja');
