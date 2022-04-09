<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Query Builder Laravel con Daniel WEBTD</title>
</head>
<body>
    <h1>Query Builder Laravel con Daniel WEBTD</h1>
    <table border="1">
        <tr>
          <th>ID Video</th>
          <th>Título</th>
          <th>Descripción</th>
          <th>Extensión</th>
          <th>Ganancia</th>
          <th>Cantidad Visitas</th>
          <th>Fecha publicación</th>
          <th>Comentario</th>
          <th>Comentario Publicado</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->idVideo }}</td>
            <td>{{ $row->titulo }}</td>
            <td>{{ $row->descripcion }}</td>
            <td>{{ $row->extension }}</td>
            <td>${{ number_format($row->ganancia_generada, 2) }}</td>
            <td>{{ number_format($row->cantidad_visitas) }}</td>
            <td>{{ $row->fecha_publicacion }}</td>
            <td>{{ $row->comentario }}</td>
            <td>@if($row->comentarioPublicado == 1)Sí@elseif(!isset($row->comentarioPublicado)) @else No @endif</td>
        </tr>
        @endforeach
      </table> 
</body>
</html>