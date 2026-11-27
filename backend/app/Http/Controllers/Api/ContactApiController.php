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

        $contacts->each(function (Contact $contact) {
            $contact->setAttribute('logo_url', $contact->logo_path
                ? \App\Services\PublicMedia::url($contact->logo_path)
                : null);
        });

        return response()->json($contacts);
    }
}
