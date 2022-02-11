@extends('layouts.app')

@section('content')
    <h1>{{ $video->video }}</h1>
    <h4>{{ $video->plataforma }}</h4>
    <h4>Fecha creación: {{ $video->created_at }}</h4>
    <h4>Fecha actualización: {{ $video->updated_at }}</h4>
@endsection