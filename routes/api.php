<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $validator = Validator::make(
        $request->all(),
        [
            'username' => 'required',
            'password' => 'required',
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->messages()
        ], 400);
    }

    $user = User::where('username', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => ['The provided credentials are incorrect.'],
        ], 401);
    }


    $token = $user->createToken($request->username)->plainTextToken;

    return response()->json([
        'message' => 'authenticated successfully',
        'toke' => $token,
    ]);
});


Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'token deleted.'
    ]);
});


Route::middleware('auth:sanctum')->apiResource('artist', ArtistController::class);
Route::middleware('auth:sanctum')->apiResource('album', AlbumController::class);

Route::middleware('auth:sanctum')->prefix("solutions")->group(function () {
    Route::get('/total-number-of-albums', function () {
        return Artist::withCount('albums')->get();
    });

    Route::get('/combined-sales-per-artist', function () {
        return Artist::withSum('albums', 'sales')->get();
    });

    Route::get('/artist-with-highest-sales', function () {
        return Artist::select('artists.*')
            ->withSum('albums', 'sales')
            ->orderBy('albums_sum_sales', 'desc')
            ->first();
    });


    Route::get('/top-albums-per-year', function (Request $request)
    {
        $year = $request->query('year', 2022);
        return Album::where('year', $year)
            ->orderBy('sales', 'desc')
            ->take(10)
            ->get();
    });

    Route::get('/search-artist-by-name', function (Request $request) {
        $searchedArtist = [];

        if ($request->query('artist_name')) {
            $query = Artist::query();
            $query->withCount('albums');
            $query->withSum('albums', 'sales');
            $query->where('name', 'like', "%{$request->query('artist_name')}%");
            $searchedArtist = $query->get();
        }

        return $searchedArtist;
    });
});
