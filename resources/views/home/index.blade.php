@extends('layout.app')

@section('content')
    <h1>Home</h1>
    @foreach($folders as $folder)
        <a href="{{route('folders.show',$folder->id)}}"><h4>{{$folder->name}}</h4></a><br>
    @endforeach
    @foreach($files as $file)
        <a href="{{route('files.show', $file->id)}}">{{$file->title}}</a><br>
    @endforeach
@endsection