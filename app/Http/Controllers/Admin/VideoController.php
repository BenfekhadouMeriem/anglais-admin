<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    // Liste des vidéos
    public function index()
    {
        $videos = Video::all();
        return view('admin.videos.index', compact('videos'));
    }

    // Afficher le formulaire d'ajout
    public function create()
    {
        return view('admin.videos.create');
    }

    // Enregistrer une vidéo
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'required|mimes:mp4,mov,avi,mp3,mpeg|max:50000', // Limite de 50 Mo
            'type' => 'required|in:free,paid',
        ]);

        // Télécharger le fichier vidéo
        $file = $request->file('file');
        $filePath = $file->store('videos', 'public'); // Stocke dans storage/app/public/videos

        // Déterminer si c'est un fichier audio ou vidéo
        $extension = $file->getClientOriginalExtension();
        $category = in_array($extension, ['mp3', 'mpeg']) ? 'audio' : 'video';

        // Créer la vidéo dans la base de données
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'type' => $request->type,
            'category' => $category, // Ajout d'une colonne "category"
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Média  téléchargée avec succès.');
    }

    // Afficher le formulaire de modification
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    // Mettre à jour une vidéo
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:mp4,mov,avi,mp3,mpeg|max:50000', // Ajout des formats audio
            'type' => 'required|in:free,paid',
        ]);
    
        // Vérifier si un nouveau fichier a été téléchargé
        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier si présent
            if ($video->file_path) {
                Storage::disk('public')->delete($video->file_path);
            }
    
            // Télécharger le nouveau fichier
            $file = $request->file('file');
            $filePath = $file->store('videos', 'public'); // Stocke dans storage/app/public/videos
    
            // Mettre à jour le chemin du fichier
            $video->file_path = $filePath;
        }
    
        // Mettre à jour les autres champs
        $video->title = $request->title;
        $video->description = $request->description;
        $video->type = $request->type;
        $video->save();
    
        return redirect()->route('admin.videos.index')->with('success', 'Média mis à jour avec succès.');
    }
    

    // Supprimer une vidéo
    public function destroy(Video $video)
    {
        // Supprimer le fichier vidéo
        Storage::disk('public')->delete($video->file_path);

        // Supprimer la vidéo de la base de données
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Vidéo supprimée avec succès.');
    }
}
