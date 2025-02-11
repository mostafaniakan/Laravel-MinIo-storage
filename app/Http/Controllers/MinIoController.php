<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MinIoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $file=Storage::disk('minio')->files('images');
        return response()->json(['data'=>$file]);
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $image = $request->file('image');


        $path = Storage::disk('minio')->put('images/' . $image->getClientOriginalName(), $image);

        if($path){
            $url=Storage::disk('minio')->url($path);
            return response()->json($url);
        }
      return response()->json("error");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $imageName)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Storage::disk('minio')->delete('images/' . $imageName);


        $image = $request->file('image');


        $path = Storage::disk('minio')->put('images/' . $image->getClientOriginalName(), $image);

        return response()->json(['message' => 'Image updated successfully!', 'path' => $path]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $imageName)
    {

        Storage::disk('minio')->delete('images/' . $imageName);

        return response()->json(['message' => 'Image deleted successfully!']);
    }
}
