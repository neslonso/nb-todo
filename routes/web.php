<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
 * Servimos la aplicación Vue.js si no nos piden una ruta de la API o Telescope
 *
 * OJO: Lo suyo sería servir la aplicación Vue.js desde un servidor web (e.g Nginx o Apache)
 * distinto al de la API y sin Laravel, pero para simplificar el ejemplo lo hacemos desde Laravel.
 */
Route::get('/{any?}', function ($any = null) {
    $path = public_path('vue3-client/'.$any);

    if ($any && file_exists($path)) {
        if (pathinfo($path, PATHINFO_EXTENSION) == 'css') {
            return response(file_get_contents($path))->header('Content-Type', 'text/css');
        } elseif (pathinfo($path, PATHINFO_EXTENSION) == 'js') {
            return response(file_get_contents($path))->header('Content-Type', 'application/javascript');
        } else {
            return file_get_contents($path);
        }
    } else {
        return file_get_contents(public_path('vue3-client/index.html'));
    }
})->where('any', '^(?!sanctum|api|telescope).*$');
