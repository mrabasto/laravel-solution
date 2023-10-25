<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'artist_id' => "required",
                'year' => "required|string",
                'name' => "required|string",
                'sales' => "required|integer",
                'release_date' => "required"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 400);
        }

        $data = $validator->validated();

        $album = Album::create($data);

        return response()->json([
            'album' => $album
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return response()->json([
            'album' => $album
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'year' => "nullable|string",
                'name' => "nullable|string",
                'sales' => "nullable|integer",
                'release_date' => "nullable"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 400);
        }

        $data = $validator->validated();

        $result = $album->update($data);

        if ($result != 1) {
            return response()->json([
                'message' => "error updating album"
            ], 500);
        }

        return response()->json([
            'message' => "album updated",
            'album' => $album->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $result = $album->delete();

        if ($result != 1) {
            return response()->json([
                'message' => "error deleting $album"
            ], 500);
        }

        return response()->json([
            'message' => "album deleted"
        ]);
    }
}
