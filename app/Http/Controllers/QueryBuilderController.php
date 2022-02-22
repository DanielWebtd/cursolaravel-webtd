<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function pruebas(Request $request)
    {
        $data = DB::table('videos')
            ->select('videos.id AS idVideo', 'titulo', 'descripcion', 'extension', 'ganancia_generada', 'comentario', 'comentarios.publicado AS comentarioPublicado', 'cantidad_visitas', 'fecha_publicacion')
            ->leftJoin('detalles_video', 'videos.id', '=', 'detalles_video.video_id')
            ->leftJoin('comentarios', 'comentarios.video_id', '=', 'videos.id')
            ->where('videos.publicado', 1)
            ->where('extension', '.mp4')
            ->orderBy('videos.id')
            ->get();

        $detallesVideo = DB::table('detalles_video')
            ->selectRaw('extension, COUNT(*) AS numeroVideos')
            ->groupBy('extension')
            ->having('extension', '=', '.mp4')
            ->get();
        
       return 'ok';

        return view('query-builder.videos')
            ->with('data', $data);
    }
}
