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
            'message' => 'required|string|max:5000',
        ]);

        foreach (['name', 'message'] as $field) {
            $normalized = mb_strtolower($data[$field], 'UTF-8');
            $normalized = strtr($normalized, ['á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'ü'=>'u', '0'=>'o', '1'=>'i', '3'=>'e', '4'=>'a', '5'=>'s', '@'=>'a']);
            if (preg_match('/(?<![\p{L}\p{N}])(?:mierda|puta|putas|puto|putos|carajo|cojudo|cojuda|cojudos|cojudas|pendejo|pendeja|pendejos|pendejas|imbecil|imbeciles|idiota|idiotas|cabron|cabrones|gilipollas|pelotudo|pelotuda|huevon|huevona|huevones|webon|webona|jodete|maricon|maricones|cabrón|conchudo|conchuda)(?![\p{L}\p{N}])/u', $normalized)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $field => 'Tu mensaje contiene lenguaje inapropiado. Por favor, reformúlalo antes de enviarlo.',
                ]);
            }
        }

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


