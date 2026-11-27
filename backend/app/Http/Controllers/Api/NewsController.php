<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
{
    News::publishDue();
    $request->validate(['q' => 'nullable|string|max:120']);
    $query = News::with('mainImage')->where('is_published', true);
    $term = trim((string) $request->query('q', ''));
    if ($term !== '') {
        $from = 'áéíóúüñ';
        $to = 'aeiouun';
        $term = strtr(mb_strtolower($term), array_combine(preg_split('//u', $from, -1, PREG_SPLIT_NO_EMPTY), str_split($to)));
        $query->where(function ($builder) use ($term, $from, $to) {
            $builder->whereRaw("strpos(translate(lower(title), ?, ?), ?) > 0", [$from, $to, $term])
                ->orWhereRaw("strpos(translate(lower(coalesce(description, '')), ?, ?), ?) > 0", [$from, $to, $term]);
        });
    }
    $news = $query->orderByDesc('published_at')->paginate(6);

    return response()->json([
        'data' => $news->getCollection()->map(function ($item) {
            return [
                'id'          => $item->id,
                'title'       => $item->title,
                'slug'        => $item->slug,
                'description' => $item->description,
                'published_at'=> optional($item->published_at)->toDateTimeString(),
                'image_url'   => $item->mainImage
                    ? \App\Services\PublicMedia::url($item->mainImage->path)
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
    News::publishDue();
    $news = News::with('images')
        ->where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    $news->increment('views');
    $news->refresh();

    return response()->json([
        'id'           => $news->id,
        'title'        => $news->title,
        'slug'         => $news->slug,
        'description'  => $news->description,
        'body'         => $news->body,
        'views'        => $news->views,
        'published_at' => optional($news->published_at)->toDateTimeString(),
        'images'       => $news->images->map(function ($img) {
            return [
                'url'     => \App\Services\PublicMedia::url($img->path),
                'is_main' => $img->is_main,
            ];
        }),
    ]);
}
    public function recent(Request $request)
{
    News::publishDue();
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
                    ? \App\Services\PublicMedia::url($item->mainImage->path)
                    : null,
            ];
        })
    );
}

}
