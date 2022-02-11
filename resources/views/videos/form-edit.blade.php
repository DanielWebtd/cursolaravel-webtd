@extends('layouts.app')

@section('content')
<form action="{{ route('videos.update', ['video' => $video->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="video">Video</label><br>
    <input type="text" id="video" name="video" value="{{ $video->video }}"><br>
    <label for="plataforma">Plataforma</label><br>
    <input type="text" id="plataforma" name="plataforma" value="{{ $video->plataforma }}"><br><br>
    <input type="submit" value="Guardar" class="btn btn-success">
</form> 
@endsection