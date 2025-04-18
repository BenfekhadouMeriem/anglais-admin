<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\TranscriptionService;
use App\Models\Content;
use App\Models\Category;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.contents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'type' => 'required|in:audio,adult,young', // Ajouter une validation
            'file' => 'required|file|mimes:mp3,mp4,mpeg,mpga,wav|max:50000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_free' => 'boolean',
        ]);

        try {
            // Fichier principal
            $file = $request->file('file');
            $filePath = $file->store('contents', 'public');
            $fullPath = storage_path('app/public/' . $filePath);

            if (!file_exists($fullPath)) {
                Log::error("❌ Fichier introuvable après l'upload : " . $filePath);
                return back()->with('error', 'Erreur : le fichier ne s’est pas enregistré correctement.');
            }

            // Transcription
            $transcriptionService = new TranscriptionService();
            $transcription = $transcriptionService->generate($filePath);

            // Image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('contents/images', 'public');

                if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                    Log::error("❌ Échec d'upload de l'image : " . $imagePath);
                    return back()->with('error', 'Erreur : l’image ne s’est pas enregistrée correctement.');
                }
            }

            // Enregistrement
            Content::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description ?? '',
                'type' => $request->type ?? 'adult',
                'file_path' => $filePath,
                'image_path' => $imagePath,
                'is_free' => $request->has('is_free') ? 1 : 0,
                'transcription' => $transcription,
            ]);

            return redirect()->route('admin.contents.index')->with('success', '✅ Contenu ajouté avec succès !');

        } catch (\Exception $e) {
            Log::error("❌ Erreur lors de l'ajout du contenu : " . $e->getMessage());
            return back()->with('error', 'Erreur : Impossible d’ajouter le contenu.');
        }
    }

    public function show(string $id)
    {
        $content = Content::findOrFail($id);
        return view('admin.contents.show', compact('content'));
    }

    public function edit($id)
    {
        $content = Content::findOrFail($id);
        $categories = Category::all();
        return view('admin.contents.edit', compact('content', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'type' => 'required|in:audio,adult,young', // Ajouter une validation
            'file' => 'required|file|mimes:mp3,mp4,mpeg,mpga,wav|max:50000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_free' => 'boolean',
        ]);

        $content->fill([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'is_free' => $request->has('is_free') ? 1 : 0,
        ]);

        if ($request->has('category_id')) {
            $content->category_id = $request->category_id;
        }

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($content->file_path);
            $filePath = $request->file('file')->store('contents', 'public');
            $content->file_path = $filePath;

            $transcriptionService = new TranscriptionService();
            $transcription = $transcriptionService->generate($filePath);
            $content->transcription = $transcription ?? $content->transcription;
        }

        if ($request->hasFile('image')) {
            if (!empty($content->image_path)) {
                Storage::disk('public')->delete($content->image_path);
            }
            $imagePath = $request->file('image')->store('contents/images', 'public');
            $content->image_path = $imagePath;
        }

        $content->save();

        return redirect()->route('admin.contents.index')->with('success', '✅ Contenu mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $content = Content::findOrFail($id);
        Storage::disk('public')->delete([$content->file_path, $content->image_path]);
        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', '✅ Contenu supprimé.');
    }

    public function getPodcasts()
    {
        $podcasts = Content::where('type', 'audio')->get();

        return response()->json($podcasts);
    }

    public function getAllContents()
    {
        $contents = Content::all();

        return response()->json([
            'message' => '✅ Liste des contenus récupérée',
            'contents' => $contents->map(function ($content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'description' => $content->description,
                    'file_path' => $content->file_path
                        ? asset('storage/' . $content->file_path)
                        : null,
                    'image_path' => $content->image_path
                        ? asset('storage/' . $content->image_path)
                        : null,
                    'transcription' => $content->transcription,
                ];
            }),
        ]);
    }


    public function getPodcastsByCategory($categoryTitle)
    {
        \Log::info("Requête pour catégorie : $categoryTitle");
        $categoryTitle = trim(urldecode($categoryTitle));
        $category = Category::whereRaw('LOWER(name) = ?', [strtolower($categoryTitle)])->first();
    
        if (!$category) {
            \Log::error("Catégorie non trouvée : $categoryTitle");
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
    
        $podcasts = $category->contents()->whereIn('type', ['adult', 'young'])->get();
        \Log::info("Podcasts trouvés pour catégorie $categoryTitle : {$podcasts->count()}");
    
        return response()->json([
            'message' => 'Podcasts récupérés avec succès',
            'contents' => $podcasts->map(function ($content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'description' => $content->description,
                    'file_path' => $content->file_path
                        ? asset('storage/' . $content->file_path)
                        : null,
                    'image_path' => $content->image_path
                        ? asset('storage/' . $content->image_path)
                        : null,
                    'transcription' => $content->transcription,
                ];
            }),
        ]);
    }
}
