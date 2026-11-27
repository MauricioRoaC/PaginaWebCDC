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
            $collapsed = preg_replace('/(\p{L})\1+/u', '$1', $normalized);
            $offensive = '/(?<![\p{L}\p{N}])(?:estupid[oa]s?|estupidez|perr[oa]s?|hij[oa]s?[\s\p{P}]+de[\s\p{P}]+(?:put[aos]*|perr[aos]*)|mal[\s\p{P}\p{S}]*parid[oa]s?|desgraciad[oa]s?|maldit[oa]s?|bastard[oa]s?|cretin[oa]s?|tarad[oa]s?|retrasad[oa]s?|subnormal(?:es)?|mongolic[oa]s?|imbecil(?:es)?|inutil(?:es)?|babos[oa]s?|bolud[oa]s?|gil(?:es)?|gilipollas|soplapollas|culer[oa]s?|cag[oa]n(?:es|as)?|cagada|cagadas|mierdas|mierder[oa]s?|mama[\s\p{P}\p{S}]*huev[oa]s?|chupapollas|chupa[\s\p{P}\p{S}]*medias|chupapijas|chupaverga|vergas?|chingad[oa]s?|chingar|joder|jodid[oa]s?|jodanse|jodete|putamadre|putamadres|hdp|hpd|ctm|ptm|pendej[oa]s?|cojud[oa]s?|cojudeces|cojudez|huevon(?:es|a|as)?|wevon(?:es|a|as)?|webon(?:es|a|as)?|huevadas?|conchud[oa]s?|pelotud[oa]s?|payas[oa]s?|imbecilidades|sin[\s\p{P}\p{S}]*verguenzas?|miserables?|asqueros[oa]s?|basuras?|idioteces|idiotez|idiotas?|putit[oa]s?|putazos?|putones?|put[oa]s?|put|pendej|estupid|cabron(?:es|a|as)?|maricon(?:es|a|as)?|maric[oa]s?|maric[a]s?|cornud[oa]s?|cabr[o]n|mal[\s\p{P}\p{S}]*nacid[oa]s?|desubicad[oa]s?|animal(?:es)?|bestias?|burros?|brut[oa]s?|tont[oa]s?|sons[oa]s?|zon[z]?[oa]s?|papanatas|pateticos?|pateticas?|infeliz(?:es)?|imbec|carajos?|caraj[o]s?|pajer[oa]s?|chot[oa]s?|forr[oa]s?|ortiv[oa]s?|culiad[oa]s?|culia[oa]s?|mal[\s\p{P}\p{S}]*cogid[oa]s?|conchetumare|conchesumare|conchatumadre|conchadesumadre|put[oa]s?[\s\p{P}]+de[\s\p{P}]+mierda|mierda|puta|putas|puto|putos|carajo|cojudo|cojuda|cojudos|cojudas|pendejo|pendeja|pendejos|pendejas|imbecil|imbeciles|idiota|idiotas|cabron|cabrones|gilipollas|pelotudo|pelotuda|huevon|huevona|huevones|webon|webona|jodete|maricon|maricones|cabrón|conchudo|conchuda)(?![\p{L}\p{N}])/u';
            if (preg_match($offensive, $normalized) || preg_match($offensive, $collapsed)) {
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


