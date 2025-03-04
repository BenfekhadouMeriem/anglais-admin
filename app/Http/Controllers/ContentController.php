<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return Content::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:audio,video',
            'file_url' => 'required|string',
        ]);

        $content = Content::create($request->all());
        return response()->json($content, 201);
    }
}