<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Acceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class RolAccesoController extends Controller
{
    public function index()
    {
        $accesos = Acceso::where('tipo', 'acceso')->get();
        return view('rol-accesos', compact('accesos'));
    }

    public function buscarControladores(Request $request)
    {
        $query = $request->get('q');
        $controllers = [];
    
        // Verificar que query no sea nulo o vacío
        if (empty($query)) {
            return response()->json($controllers);
        }
    
        // Convertir la query a minúsculas y dividirla en palabras
        $queryWords = explode(' ', strtolower($query));
    
        // Ruta de los controladores
        $controllerPath = app_path('Http/Controllers');
        if (!File::exists($controllerPath)) {
            return response()->json(['error' => 'El directorio de controladores no existe'], 404);
        }
    
        // Busca controladores en el directorio de controladores
        foreach (File::allFiles($controllerPath) as $file) {
            $filename = $file->getFilename();
    
            if (Str::endsWith($filename, '.php')) {
                $controllerName = Str::replaceLast('.php', '', $filename);
                $controllerNameLower = strtolower($controllerName);
    
                $match = true;
                foreach ($queryWords as $word) {
                    if (!Str::contains($controllerNameLower, $word)) {
                        $match = false;
                        break;
                    }
                }
    
                if ($match) {
                    $controllers[] = $controllerName;
                }
            }
        }
    
        return response()->json($controllers);
    }

    public function create()
    {
        $accesos = Acceso::where('tipo', 'acceso')->get();
        return view('rol-accesos', compact('accesos'));
    }

    public function storeRol(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Rol::create([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->route('roles.create')->with('success', 'Rol creado con éxito.');
    }

    public function storeRolModal(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Rol::create([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Rol creado con éxito.');
    }

    public function storeAcceso(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'controlador' => 'required|string|max:255',
        'tipo' => 'required|string',
        'idacceso' => 'nullable|integer|in:0,' . implode(',', Acceso::pluck('id')->toArray()),
    ]);

    // Preparar los datos para la creación
    $data = $request->only(['nombre', 'controlador', 'tipo']);

    // Incluir idacceso si el tipo es subacceso
    if ($request->input('tipo') == 'subacceso') {
        $data['idacceso'] = $request->input('idacceso', 0);
    } else {
        // Asegúrate de que idacceso esté presente pero como NULL si no es subacceso
        $data['idacceso'] = 0;
    }

    // Crear el nuevo acceso
    Acceso::create($data);

    // Redirigir con un mensaje de éxito
    return redirect()->route('roles.create')->with('success', 'Acceso creado con éxito.');
}

}