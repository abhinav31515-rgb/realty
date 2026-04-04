<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
class ContentController extends Controller {
    public function index(Request $request) {
        $type = $request->query('type'); $query = Content::query();
        if ($type) $query->where('type', $type);
        return response()->json($query->get());
    }
    public function show(Content $content) { return response()->json($content); }
    public function store(Request $request) {
        if ($request->user()->role !== 'admin') return response()->json(['message' => 'Unauthorized'], 403);
        $validated = $request->validate(['title' => 'required|string', 'slug' => 'required|string|unique:contents', 'body' => 'required|string', 'type' => 'required|string', 'images' => 'array']);
        $content = Content::create($validated);
        return response()->json($content, 201);
    }
}
