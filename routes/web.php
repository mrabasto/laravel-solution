<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ProfileController;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return to_route('login');
});

Route::get('/dashboard', function (Request $request) {
    $albumsSold = Artist::withCount('albums')->get();
    $combinedSales = Artist::withSum('albums', 'sales')->get();
    $artistHighestSales = Artist::select('artists.*')
        ->withSum('albums', 'sales')
        ->orderBy('albums_sum_sales', 'desc')
        ->first();

    // $topAlbums = Album::where('year', '2022')
    //     ->orderBy('sales', 'desc')
    //     ->take(10)
    //     ->get();

    $searchedArtist = [];
    
    if ($request->query('artist_name')) {
        $query = Artist::query();
        $query->withCount('albums');
        $query->withSum('albums', 'sales');
        $query->where('name', 'like', "%{$request->query('artist_name')}%");
        $searchedArtist = $query->get();
    }

    return view('dashboard', compact('albumsSold', 'combinedSales', 'artistHighestSales', 'searchedArtist'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('artist', ArtistController::class);

require __DIR__ . '/auth.php';
