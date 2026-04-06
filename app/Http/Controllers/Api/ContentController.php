<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller {
    public function index(Request $request) {
        $query = Content::query();
        if ($request->type) $query->where('type', $request->type);
        return ContentResource::collection($query->get());
    }
    public function show(Content $content) { return new ContentResource($content); }
    public function store(StoreContentRequest $request) {
        return new ContentResource(Content::create($request->validated()));
    }
}
