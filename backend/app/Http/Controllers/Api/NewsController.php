<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
{
    $news = News::with('mainImage')
        ->where('is_published', true)
        ->orderByDesc('published_at')
        ->paginate(6);

    return response()->json([
        'data' => $news->getCollection()->map(function ($item) {
            return [
                'id'          => $item->id,
                'title'       => $item->title,
                'slug'        => $item->slug,
                'description' => $item->description,
                'published_at'=> optional($item->published_at)->toDateTimeString(),
                'image_url'   => $item->mainImage
                    ? asset('storage/'.$item->mainImage->path)
                    : null,
            ];
        }),
        'meta' => [
            'current_page' => $news->currentPage(),
            'last_page'    => $news->lastPage(),
            'per_page'     => $news->perPage(),
            'total'        => $news->total(),
        ]
    ]);
}


    public function show($slug)
    {
        $news = News::with('images')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'id'          => $news->id,
            'title'       => $news->title,
            'slug'        => $news->slug,
            'description' => $news->description,
            'body'        => $news->body,
            'published_at'=> optional($news->published_at)->toDateTimeString(),
            'images'      => $news->images->map(function ($img) {
                return [
                    'url'     => asset('storage/'.$img->path),
                    'is_main' => $img->is_main,
                ];
            }),
        ]);
    }
    public function recent(Request $request)
{
    $excludeSlug = $request->query('exclude_slug');

    $query = News::with('mainImage')
        ->where('is_published', true)
        ->orderByDesc('published_at');

    if ($excludeSlug) {
        $query->where('slug', '!=', $excludeSlug);
    }

    // 3 recientes (puedes cambiar a 4, 5, etc.)
    $items = $query->limit(4)->get();

    return response()->json(
        $items->map(function ($item) {
            return [
                'id'          => $item->id,
                'title'       => $item->title,
                'slug'        => $item->slug,
                'published_at'=> optional($item->published_at)->toDateTimeString(),
                'image_url'   => $item->mainImage
                    ? asset('storage/'.$item->mainImage->path)
                    : null,
            ];
        })
    );
}

}
