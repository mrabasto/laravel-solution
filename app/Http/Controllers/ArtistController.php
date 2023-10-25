<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Artist;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Artist::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 400);
        }

        $data = $validator->validated();
        $data['code'] = str()->uuid();

        $artist = Artist::create($data);

        return response()->json([
            'artist' => $artist
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        return response()->json([
            'artist' => $artist
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 400);
        }

        $data = $validator->validated();

        $result = $artist->update($data);

        if ($result != 1) {
            return response()->json([
                'message' => "error updating artist"
            ], 500);
        }

        return response()->json([
            'message' => "artist updated",
            'artist' => $artist->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        $result = $artist->delete();

        if ($result != 1) {
            return response()->json([
                'message' => "error deleting artist"
            ], 500);
        }


        return response()->json([
            'message' => "artist deleted"
        ]);
    }
}
