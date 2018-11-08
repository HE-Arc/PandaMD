@extends('layout.app')

@section('content')

    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active bg-dark">
            <h1>{{$folder->name}}</h1>
        </a>
    @foreach($folders as $folder)
        <a href="{{route('folders.show',$folder->id)}}" class="list-group-item list-group-item-action">
            <h3> <i class="fal fa-folder fa-fw"></i> {{$folder->name}}</h3></a>
    @endforeach

    @foreach($files as $file)
        <a href="{{route('files.show', $file->id)}}" class="list-group-item list-group-item-action" style="font-family: 'Titillium Web', sans-serif;font-size: 20px;">
        <i class="fal fa-file fa-fw"></i> {{$file->title}}</a><br>
    @endforeach
    </div>
@endsection