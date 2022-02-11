@extends('layouts.app')

@section('content')
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
            <form action="{{ route('videos.store') }}" method="POST">
                @csrf
                <label for="video">Video</label><br>
                <input type="text" id="video" name="video" value="{{ old('video') }}"><br>
                <label for="plataforma">Plataforma</label><br>
                <input type="text" id="plataforma" name="plataforma" value="{{ old('plataforma') }}"><br><br>
                <input type="submit" value="Guardar" class="btn btn-success">
            </form>         
        </div>
    </div>
</div>
@endsection