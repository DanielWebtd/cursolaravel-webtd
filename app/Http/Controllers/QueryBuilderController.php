<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function pruebas(Request $request)
    {
        $extension = $request->extension;
        $gananciaGenerada = $request->gananciaGenerada;
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;

        '' => null => false

        /* '' => false-falsy, '0' => falsy TRUE
             */
        $data = DB::table('videos') // Empezar Query Builder y a su vez "equivale" a clausula FROM.
            ->select('videos.id AS idVideo', 'titulo', 'descripcion', 'extension', 'ganancia_generada', 'comentario', 'comentarios.publicado AS comentarioPublicado', 'cantidad_visitas', 'fecha_publicacion')
            ->leftJoin('detalles_video', 'videos.id', '=', 'detalles_video.video_id')
            ->leftJoin('comentarios', 'comentarios.video_id', '=', 'videos.id')
            ->where('videos.publicado', 1)

            /* la funcion callback que when se aplica cuando el valor-variable se evalue a TRUE. */
            ->when($extension, function($query, $extension) {
                

            })
            ->orderBy('videos.id')
            ->get(); // a partir de aqui ya es una coleccion.
    
        return view('query-builder.videos')
            ->with('data', $data);
    }

    public function filtros() 
    {
        return view('query-builder.form-filtros');
    }
}
