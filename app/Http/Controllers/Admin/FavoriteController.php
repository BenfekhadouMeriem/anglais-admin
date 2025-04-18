<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite; 

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Utilisateur connecté
        $favorites = $user->favoriteContents; // Récupère tous les contenus favoris

        return view('admin.favorites.index', compact('favorites')); // Retourne la vue avec les favoris
    }

    public function addFavorite(Request $request, $contentId)
    {
        $user = auth()->user(); // Récupère l'utilisateur connecté

        // Vérifie si ce contenu est déjà dans les favoris
        if (Favorite::where('user_id', $user->id)->where('content_id', $contentId)->exists()) {
            return response()->json(['message' => 'Ce contenu est déjà dans vos favoris.'], 400);
        }

        // Ajoute le contenu aux favoris
        Favorite::create([
            'user_id' => $user->id,
            'content_id' => $contentId,
        ]);

        return response()->json(['message' => 'Contenu ajouté aux favoris.'], 200);
    }

    public function removeFavorite(Request $request, $contentId)
    {
        $user = auth()->user(); // Récupère l'utilisateur connecté

        // Recherche et supprime le contenu des favoris
        $favorite = Favorite::where('user_id', $user->id)->where('content_id', $contentId)->first();

        if (!$favorite) {
            return response()->json(['message' => 'Ce contenu n\'est pas dans vos favoris.'], 400);
        }

        // Supprimer le favori
        $favorite->delete();

        return response()->json(['message' => 'Contenu supprimé des favoris.'], 200);
    }

    public function isFavorite($contentId)
    {
        $user = auth()->user(); // Récupère l'utilisateur connecté
    
        $favoriteExists = Favorite::where('user_id', $user->id)->where('content_id', $contentId)->exists();
    
        return response()->json(['is_favorite' => $favoriteExists], 200);
    }
    
}
