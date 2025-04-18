<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Content;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        $categories = $query->latest()->get(); // ou paginate si tu veux la pagination
    
        return view('admin.category.index', compact('categories'));
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
    
        $data = $request->only('name');
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public'); // stockage dans storage/app/public/categories
        }
    
        Category::create($data);
    
        return redirect()->route('admin.category.index')->with('success', 'Catégorie créée avec image.');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category')); 
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);
    
        $category = Category::findOrFail($id);
    
        $data = ['name' => $request->name];
    
        // Si une nouvelle image est envoyée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
    
            // Stocker la nouvelle image
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
    
        $category->update($data);
    
        return redirect()->route('admin.category.index')->with('success', 'Catégorie mise à jour.');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }

    public function getCategories()
    {
        \Log::info("Récupération des catégories");
        $categories = Category::withCount(['contents' => function($query) {
            $query->whereIn('type', ['adult', 'young']);
        }])->get();
    
        \Log::info("Catégories trouvées : {$categories->count()}");
    
        return response()->json([
            'categories' => $categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image
                        ? asset('storage/' . $category->image)
                        : null,
                    'contents_count' => $category->contents_count
                ];
            })
        ]);
    }
}
