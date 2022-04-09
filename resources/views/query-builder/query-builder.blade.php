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
          <th>Fecha publicación</th>
          <th>Extensión</th>
          <th>Ganancia generada</th>
          <th>Dimensiones</th>
          {{-- <th>Fecha creación</th> --}}
        </tr>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->fecha_publicacion }} </td>
                <td>{{ $row->extension }} </td>
                <td>{{ $row->ganancia }} </td>
                <td>{{ $row->dimensiones }} </td>
            <tr>
        @endforeach
      </table> 
</body>
</html>