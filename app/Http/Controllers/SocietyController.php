<?php

namespace App\Http\Controllers;

use App\Http\Resources\SocietyResource;
use App\Models\Society;
use Illuminate\Http\Request;

class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Society::all();
        return new SocietyResource($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:societies,name',
            'logo' => 'required',
            'description' => 'required|string',
        ]);

        $data = Society::create($request->only(['name', 'logo', 'description']));

        return new SocietyResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Society::find($id);
        return new SocietyResource($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|mimes:jpg,png|max:2048',
            'description' => 'required|string',
        ]);

        // Find the record by its ID
        $record = Society::find($id);

        $update = $record->update($request->only(['name', 'logo', 'description']));

        return response()->json(['data' => $update], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Society::find($id);
        $delete = $record->delete();
        return response()->json(['data' => $delete], 200);
    }
}
