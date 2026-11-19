<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Routes are protected by authentication middleware to prevent
| unauthenticated users from accessing administrative or menu areas.
|
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Protected Application Routes (Jetstream Authentication & Session)
|--------------------------------------------------------------------------
| All routes within this group require valid authentication.
| Unauthenticated requests are redirected automatically to the login page.
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Restaurant Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Controller-based route group for Menu Management (no Route::resource())
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        // GET routes
        // Deliberate educational convention:
        // index() displays the add-menu form
        Route::get('/create', 'index')->name('index');

        // create() displays the menu items list
        Route::get('/list', 'create')->name('create');

        // edit() displays the edit-menu form
        Route::get('/edit/{id}', 'edit')->name('edit');

        // POST route to store a new item
        Route::post('/store', 'store')->name('store');

        // PUT route to update an existing item
        Route::put('/update/{id}', 'update')->name('update');

        // DELETE route to delete an item
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });
});
