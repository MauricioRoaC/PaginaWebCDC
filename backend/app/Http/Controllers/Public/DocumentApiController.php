<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::where('is_public', true);

        if ($request->has('type')) {
            $query->where('type', $request->query('type'));
        }

        $documents = $query->orderBy('created_at', 'desc')->get();

        return response()->json(
            $documents->map(function ($doc) {
                return [
                    'id'          => $doc->id,
                    'number'      => $doc->number,
                    'title'       => $doc->title,
                    'description' => $doc->description,
                    'type'        => $doc->type,
                    'url'         => $doc->url, // accessor
                ];
            })
        );
    }
}
