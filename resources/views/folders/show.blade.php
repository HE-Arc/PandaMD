@extends('layout.app')

@section('content')

    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
            {{$folder->name}}
        </a>
        <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
    </div>
    <h1></h1>
    @foreach($folders as $folder)
        <a href="{{route('folders.show',$folder->id)}}"><h4>{{$folder->name}}</h4></a><br>
    @endforeach
    @foreach($files as $file)
        <a href="{{route('files.show', $file->id)}}">{{$file->title}}</a><br>
    @endforeach
@endsection