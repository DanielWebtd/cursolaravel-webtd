@extends('layouts.app')

@section('content')
<h1>Videos</h1>
<div class="container">
    <div class="row">
        <div class="col-12">
            @if (Session::has('exito'))
            <div class="alert alert-success">
                <h3>{{ Session::get('exito') }}</h3>
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <a href="{{ route('videos.create') }}" class="btn btn-primary mb-5">Nuevo</a>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Video</th>
                    <th scope="col">Plataforma</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($videos as $video)
                    <tr>
                      <td><a href="{{ route('videos.show', ['video' => $video->id]) }}">{{ $video->video }}</a></td>
                      <td>{{ $video->plataforma }}</td>
                      <td>
                        {{-- cambio en este boton --}}
                        <button type="button" class="btn btn-warning" 
                          data-bs-toggle="modal" data-bs-target="#modalEditarVideo" 
                          data-video='@json($video)'>Editar
                        </button>

                        <a href="{{ route('videos.edit', ['video' => $video->id]) }}" class="btn btn-warning">Actualizar</a>
                        {{-- cambio en este boton --}}
                        <button type="button" class="btn btn-danger" 
                          data-bs-toggle="modal" data-bs-target="#modalEliminarVideo" 
                          data-idvideo="{{ $video->id }}">Eliminar
                        </button>
                      </td>
                    </tr>
                  @empty
                    ¡No se han encontrado registros¡
                  @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modalesBootstrap')
<div class="modal fade" id="modalEditarVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">{{-- cambio en esta linea --}}
        </button>
      </div>
      <div class="modal-body">
        {{-- form method spoofing --}}
        <form id="formEditarVideo" method="POST" action="">
          @method('PUT')
          @csrf
          <label for="e-video">Video</label><br>
          <input type="text" id="e-video" name="video" value="{{ old('video') }}"><br>
          <label for="e-plataforma">Plataforma</label><br>
          <input type="text" id="e-plataforma" name="plataforma" value="{{ old('plataforma') }}"><br><br>
          <input type="submit" value="Guardar" class="btn btn-success">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>{{-- cambio en esta linea --}}
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalEliminarVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>{{-- cambio en esta linea --}}
      </div>
      <div class="modal-body">
        {{-- form method spoofing --}}
        <form id="formEliminarVideo" method="POST" action="">
          @method('DELETE')
          @csrf
          <input type="submit" value="Eliminar" class="btn btn-success">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>{{-- cambio en esta linea --}}
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('miJS')
  <script>
    let modalEditarVideo = document.getElementById('modalEditarVideo'); // cambio en esta linea
    let urlVideos = "{{ url('/videos') }}";
    let formEditarVideo = document.querySelector('#formEditarVideo');
    let eVideo = document.querySelector('#e-video');
    let ePlataforma = document.querySelector('#e-plataforma');
    modalEditarVideo.addEventListener('show.bs.modal', function (event) { // cambio en esta linea

      let botonPresionado = event.relatedTarget // cambio en esta linea
      let videoEditar = botonPresionado.getAttribute('data-video'); // cambio en esta linea
      videoEditar = JSON.parse(videoEditar); // cambio en esta linea
      eVideo.value = videoEditar.video;
      ePlataforma.value = videoEditar.plataforma;
      formEditarVideo.action = `${urlVideos}/${videoEditar.id}`;
    });

    let modalEliminarVideo = document.getElementById('modalEliminarVideo'); // cambio en esta linea
    let formEliminarVideo = document.querySelector('#formEliminarVideo');
    modalEliminarVideo.addEventListener('show.bs.modal', function (event) { // cambio en esta linea

      let botonPresionado = event.relatedTarget // cambio en esta linea
      let idVideo = botonPresionado.getAttribute('data-idvideo'); // cambio en esta linea
      formEliminarVideo.action = `${urlVideos}/${idVideo}`;
    });
  </script>
@endsection