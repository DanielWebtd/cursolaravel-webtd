<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Services\EncriptacionService;

class VideosController extends Controller
{
    private EncriptacionService $encriptacionService;

    /* $encriptacionService = new EncriptacionService();
     */
    /* Service container, contenedor de servicios. */
    public function __construct(EncriptacionService $encriptacionService)
    {
        $this->middleware(function($request, $next) {

            $datos = $request->all();
            $datos['plataforma'] = strtoupper($request->plataforma);
            $request->replace($datos);
            $response = $next($request);
            return $response;
        })->only(['store', 'update']);

        $this->encriptacionService = $encriptacionService;
        /* $this->encriptacionService = new EncriptacionService(); */
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();
        return view('videos.index')
            ->with('videos', $videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.form-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [

            'video' => ['required'],
            'plataforma' => ['required']
        ];
        $request->flash(); // Flashea los inputs en caso de errores de validacion.
        $request->validate($reglas); // flashea los inputs en caso de error de validacion.
        $video = Video::create($request->all());

        /* POST-REDIRECT-GET */
        return redirect()
            ->route('videos.create')
            ->with('exito', '¡Registro guardado correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        
       return view('videos.show')
        ->with('video', $video);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $reglas = [

            'video' => ['required'],
            'plataforma' => ['required']
        ];
        $request->flash(); // Flashea los inputs en caso de errores de validacion.
        $request->validate($reglas); // flashea los inputs en caso de error de validacion.
        $video = $video->update($request->all());
        return redirect()
            ->route('videos.index')
            ->with('exito', '¡Registro actualizado correctamente!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()
            ->route('videos.index')
            ->with('exito', '¡Registro eliminado correctamente!');
    }

    public function edit(Video $video) {
        
        return view('videos.form-edit')
            ->with('video', $video);
    }

    public function otraAccion() 
    {
        $cadenaRandom = $this->encriptacionService->generarCadenaAleatoria();
        return "HASH: {$cadenaRandom}";
    }

    public function hash() {

        $cadenaRandom = $this->encriptacionService->generarCadenaAleatoria();
        return "Otro HASH: {$cadenaRandom}";
    }

    public function pruebas(Request $request) {

        return Banco::create(['nombre' => $request->banco, 'siglas' => $request->siglas]);
    }
}
