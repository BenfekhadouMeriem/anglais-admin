<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Podcast;

class PodcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $podcasts = Podcast::all();
        return view('admin.podcasts.index', compact('podcasts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.podcasts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'audio_path' => 'required|string',
            'is_paid' => 'boolean',
        ]);

        Podcast::create($request->all());

        return redirect()->route('admin.podcasts.index')->with('success', 'Podcast ajouté');
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
        return view('admin.podcasts.edit', compact('podcast'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $podcast->update($request->all());
        return redirect()->route('podcasts.index')->with('success', 'Podcast mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $podcast->delete();
        return redirect()->route('podcasts.index')->with('success', 'Podcast supprimé');
    }
}
