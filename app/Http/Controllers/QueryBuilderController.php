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
            ->where('extension', '.mp4') // extension = '.mp4'
            ->orderBy('videos.id')
            ->get();

        $subconsulta1 = DB::table('videos')
            ->where('videos.id', 1)
            ->whereNotIn('videos.id', function($query) {

                $query->select('videos.id')
                    ->from('videos AS v')
                    ->join('users', 'users.id', '=', 'videos.user_id')
                    ->where('email', 'LIKE', '%example.com%')
                    ->distinct();
            })
            ->get();

        $subconsulta2 = DB::table('detalles_video')
            ->select('video_id')
            ->where('ganancia_generada', function($query) {

                $query->selectRaw('MAX(ganancia_generada)')
                    ->from('detalles_video AS detalles_video_s')
                    ->limit(1);
            })
            ->get();

        $subconsulta5 = DB::table('detalles_video')
            ->select('video_id')
            ->whereRaw('ganancia_generada > (SELECT MAX(ganancia_generada) FROM detalles_video AS detalles_video_s LIMIT 1)')
            ->get();
        
        $subconsulta3 = DB::table('videos')
            ->where(function($query) {

                $query->select('extension')
                    ->from('detalles_video')
                    ->join('videos AS videos_s', 'videos_s.id', '=', 'detalles_video.video_id')
                    ->whereColumn('videos_s.id', 'videos.id');
            },'<=', '.mp4')
            ->orderBy('id')
            ->get();
        $subconsulta4 = DB::table('videos')
            ->whereRaw('(SELECT extension FROM detalles_video INNER JOIN videos videos_s ON videos_s.id = detalles_video.video_id WHERE videos_s.id = videos.id) = ".mp4"')
            ->orderBy('id')
            ->get();
        return 'ok';
        return view('query-builder.videos')
            ->with('data', $data);
    }
}
