<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::withCount('songs')->orderBy('name')->paginate(20);
        return view('artists.index', compact('artists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:artists,name',
            'bio' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Artist::create($validated);

        return redirect()->route('artists.index')->with('success', 'Artista cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        $artist->load('songs');
        return view('artists.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:artists,name,' . $artist->id,
            'bio' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $artist->update($validated);

        return redirect()->route('artists.index')->with('success', 'Artista atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('artists.index')->with('success', 'Artista removido com sucesso!');
    }
}
