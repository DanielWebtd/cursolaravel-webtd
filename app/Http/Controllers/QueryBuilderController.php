<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function pruebas(Request $request)
    {
        $data = DB::table('videos') // Empezar Query Builder y a su vez "equivale" a clausula FROM.
            ->select('videos.id AS idVideo', 'titulo', 'descripcion', 'extension', 'ganancia_generada', 'comentario', 'comentarios.publicado AS comentarioPublicado', 'cantidad_visitas', 'fecha_publicacion')
            ->leftJoin('detalles_video', 'videos.id', '=', 'detalles_video.video_id')
            ->leftJoin('comentarios', 'comentarios.video_id', '=', 'videos.id')
            ->where('videos.publicado', 1)
            ->where('extension', '.mp4') // extension = '.mp4'
            ->orderBy('videos.id')
            ->get(); // a partir de aqui ya es una coleccion.
        
        $QBPlataformas = DB::table('plataformas')
            ->select('id', 'plataforma');
        
        $unUnion = DB::table('bancos')
            ->select('id AS ids', 'nombre AS instituciones')
            ->union($QBPlataformas)
            ->orderBy('ids')
            ->get();

        dd($unUnion);
        return view('query-builder.videos')
            ->with('data', $data);
    }
}
