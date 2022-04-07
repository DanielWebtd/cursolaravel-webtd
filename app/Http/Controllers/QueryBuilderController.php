<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QueryBuilderController extends Controller
{
    public function pruebas(Request $request)
    {
        $extension = $request->extension;
        $gananciaGenerada = $request->gananciaGenerada;
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;

        

        $data = DB::table('videos') // Empezar Query Builder y a su vez "equivale" a clausula FROM.
            ->select('videos.id AS idVideo', 'titulo', 'descripcion', 'extension', 'ganancia_generada', 'comentario', 'comentarios.publicado AS comentarioPublicado', 'cantidad_visitas', 'fecha_publicacion')
            ->leftJoin('detalles_video', 'videos.id', '=', 'detalles_video.video_id')
            ->leftJoin('comentarios', 'comentarios.video_id', '=', 'videos.id')
            ->where('videos.publicado', 1)

            /* la funcion callback "when" se aplica cuando el valor-variable (primer parametro) se evalue a TRUE,
            que sea un valor TRUTHY.*/
            ->when($extension, function($query, $extension) {
                
                return $query->where('extension', $extension);
            })
            ->when($gananciaGenerada, function($query, $gananciaGenerada) {
                
                return $query->where('ganancia_generada', (float)$gananciaGenerada);
            })
            ->when($fecha1, function($query) use($request) {
                
                return $query->whereBetween('fecha_publicacion', [$request->fecha1, $request->fecha2]);
            })
            ->when($request->ordenacion, function($query) use($request) {
                
                switch ($request->ordenacion) {

                    case 'ganancia_generada':
                        
                        return $query->orderBy('ganancia_generada');
                    break;
                    case 'titulo':
                        return $query->orderBy('titulo');
                    break;
                }
            }, function($query) {

                /* si entro aqui es porque el primer parametro no es un valor truthy sino falsy */
                return $query->orderBy('videos.id');
            })
            ->get(); // a partir de aqui ya es una coleccion.
    
        return view('query-builder.videos')
            ->with('data', $data);
    }

    public function filtros() 
    {
        return view('query-builder.form-filtros');
    }

    public function insert() 
    {
        $idComentarioInsertado = DB::table('comentarios')->insertGetId([

                'comentario' => 'excelente trabajo',
                'video_id' => 5,
                'publicado' => 0,
                'created_at' => now(),
                'updated_at' => now()
        ]);

        dd($idComentarioInsertado);
    }

    public function update() 
    {
        $numRegistrosAfectados = DB::table('users')
        
            ->where('id', 503)
            ->update(['email' => 'juan.perez2022@hotmail.com', 'name' => 'juanitoP', 'updated_at' => now()]);

        dd($numRegistrosAfectados);
    }

    public function delete() 
    {
        /* implicit commmit. */
        DB::beginTransaction(); // Afuera del try.
        try {

            DB::table('detalles_video')
                ->where('video_id', 7)
                ->delete();
        
            DB::table('comentarios')
                ->where('video_id', 7)
                ->delete();
            
            DB::table('clasificacion_video')
                ->where('video_id', 7)
                ->delete();

            DB::statement('CREATE TABLE una_tabla (columna VARCHAR(255) NULL)'); // ¡CUIDADO! - genera commit implicito! - DB::commit();
            // Despues de aqui se committed la transaccion.
            
            DB::table('videos')
                ->where('id', 7)
                ->delete();

            /* SI LLEGO HASTA AQUI NO HUBO EXCEPCION EN LAS
            ANTERIORES SENTENCIAS */
            DB::commit(); // Confirmamos todo.
            return 'ok';
        } catch(\Exception $e) {

            DB::rollBack();
            throw $e;
        } 
        catch (\Throwable $e) {
            
            DB::rollBack(); // Cancelamos, revertimos todo.
            throw $e; // re-throw.
        }
    }
}
