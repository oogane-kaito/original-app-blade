<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
//micropost関連
use App\Http\Controllers\MicropostsController; 
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\FavoritesController;


//オリジナルアプリ関連
use App\Http\Controllers\EditorController;
use App\Http\Controllers\BusinessCardController;

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

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [MicropostsController::class, 'index']);

Route::get('/dashboard', [MicropostsController::class, 'index'])->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/editor', [EditorController::class, 'index'])->name('editor.index');
    
    Route::prefix('users/{id}')->group(function () {
            Route::post('follow', [UserFollowController::class, 'store'])->name('user.follow');
            Route::delete('unfollow', [UserFollowController::class, 'destroy'])->name('user.unfollow');
            Route::get('followings', [UsersController::class, 'followings'])->name('users.followings');
            Route::get('followers', [UsersController::class, 'followers'])->name('users.followers');

            Route::get('favorites', [UsersController::class, 'favorites'])->name('users.favorites');
        });

    Route::prefix('microposts/{id}')->group(function() {
        Route::post('favorites', [FavoritesController::class, 'store'])->name('favorites.favorite');
        Route::delete('unfavorite', [FavoritesController::class, 'destroy'])->name('favorites.unfavorite');
    });

    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('microposts', MicropostsController::class, ['only' => ['store', 'destroy']]);
    Route::resource('business-cards', BusinessCardController::class);

});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// Public card view (no auth required)
Route::get('/cards/{id}', [EditorController::class, 'show'])->name('cards.show');


require __DIR__.'/auth.php';
