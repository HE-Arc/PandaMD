@extends('layout.app')

@section('content')
    <h1>{{$file->title}}</h1>
    @parsedown($file->content)

@endsection