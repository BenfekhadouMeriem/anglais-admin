<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Content;

class ContentController extends Controller
{
    /**
     * Afficher la liste des contenus.
     */
    public function index()
    {
        $contents = Content::all();
        return view('admin.contents.index', compact('contents'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin.contents.create');
    }

    /**
     * Enregistrer un nouveau contenu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:mp4,mov,avi,mp3,mpeg|max:50000',
        ]);
    
        try {
            // 1️⃣ 📂 **Téléchargement du fichier**
            $file = $request->file('file');
            $filePath = $file->store('contents', 'public');  // Stockage dans storage/app/public/contents/
            $fullPath = storage_path('app/public/' . $filePath); // Chemin absolu
    
            // 2️⃣ 🔍 **Vérifier si le fichier existe après l'upload**
            if (!file_exists($fullPath)) {
                Log::error("❌ Fichier introuvable après l'upload : " . $fullPath);
                return redirect()->back()->with('error', 'Erreur : le fichier ne s’est pas enregistré correctement.');
            }
    
            Log::info("✅ Fichier uploadé avec succès : " . $fullPath);
    
            // 3️⃣ 📝 **Générer la transcription**
            $transcription = $this->generateTranscription($filePath);
    
            // Ajouter un log pour vérifier la transcription
            Log::info("Transcription générée : " . $transcription);
    
            // 4️⃣ 🗃 **Enregistrer dans la base de données**
            Content::create([
                'title' => $request->title,
                'description' => $request->description ?? '',
                'type' => $request->type ?? 'audio', // Par défaut "audio"
                'file_path' => $filePath,
                'is_free' => $request->has('is_free') ? 1 : 0,
                'transcription' => $transcription, // Enregistrer la transcription dans la base
            ]);
    
            return redirect()->route('admin.contents.index')->with('success', '✅ Contenu ajouté avec succès !');
    
        } catch (\Exception $e) {
            Log::error("❌ Erreur lors de l'ajout du contenu : " . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur : Impossible d’ajouter le contenu.');
        }
    }
    
    

    /**
     * Afficher un contenu spécifique.
     */
    public function show(string $id)
    {
        $content = Content::findOrFail($id);
        return view('admin.contents.show', compact('content'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(string $id)
    {
        $content = Content::findOrFail($id);
        return view('admin.contents.edit', compact('content'));
    }

    /**
     * Mettre à jour un contenu existant.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);
    
        $request->validate([
            'title' => 'required',
            'file' => 'nullable|mimes:mp4,mov,avi,mp3,mpeg|max:50000',
        ]);
    
        $content->title = $request->title;
        $content->description = $request->description;
        $content->type = $request->type;
        $content->is_free = $request->has('is_free') ? 1 : 0;
    
        // Vérifier si un nouveau fichier a été téléchargé
        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            Storage::disk('public')->delete($content->file_path);
    
            // Enregistrer le nouveau fichier
            $file = $request->file('file');
            $filePath = $file->store('contents', 'public');
            $content->file_path = $filePath;
    
            // Générer la transcription pour le nouveau fichier
            $transcription = $this->generateTranscription($filePath); // Passer le chemin relatif
            if ($transcription) {
                $content->transcription = $transcription;
            } else {
                Log::error("❌ Échec de la génération de la transcription pour le fichier : " . $filePath);
                // Vous pouvez choisir de conserver l'ancienne transcription ou de la supprimer
                $content->transcription = null; // Ou conserver l'ancienne transcription
            }
        }
    
        // Sauvegarder les données mises à jour
        $content->save();
    
        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully');
    }

    /**
     * Supprimer un contenu.
     */
    public function destroy(string $id)
    {
        $content = Content::findOrFail($id);

        // Supprimer le fichier du stockage
        Storage::disk('public')->delete($content->file_path);

        // Supprimer le contenu de la base de données
        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Content deleted successfully');
    }

    /**
     * Générer la transcription d'un fichier audio ou vidéo.
     */
    private function generateTranscription($filePath)
    {
        set_time_limit(300);
        // Construire le chemin absolu du fichier
        $fullPath = storage_path('app/public/' . $filePath);
    
        // Vérifiez que le fichier existe
        if (!file_exists($fullPath)) {
            Log::error("❌ Fichier introuvable pour la transcription : " . $fullPath);
            return null;
        }
    
        // Log pour vérifier que le fichier existe
        Log::info("✅ Fichier trouvé pour la transcription : " . $fullPath);
    
        // Utiliser le chemin absolu dans la commande
        $command = 'whisper "' . $fullPath . '" --model small --language en';

        // Exécuter la commande shell et récupérer la sortie
        $output = shell_exec($command);

        // Nettoyer la sortie en supprimant les balises HTML
        $cleanedOutput = strip_tags($output);
    
        // Log de la sortie pour vérifier
        Log::info("Sortie de la commande whisper : " . $output);
    
        return $output; // Retourner la transcription ou la sortie
    }
    
    
}
