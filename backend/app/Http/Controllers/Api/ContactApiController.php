<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactApiController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')
            ->where('is_visible', true)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get();

        return response()->json($contacts);
    }
}
