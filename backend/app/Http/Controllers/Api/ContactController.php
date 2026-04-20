<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name'    => $data['name'],
            'email'   => $data['email'] ?? null,
            'subject' => "Consulta desde el formulario web",
            'message' => $data['message'],
            'ip'      => $request->ip(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return 'Mensaje enviado correctamente.';
    }
}


