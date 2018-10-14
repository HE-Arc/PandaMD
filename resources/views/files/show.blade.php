@extends('layout.app')

@section('content')

    <h1>{{$file->title}} <a href="{{route('files.edit', $file)}}" class="btn btn-primary float-right">edit</a></h1>
    <div id="content-mdfile" class="border-top pt-4">

    </div>
    <script>
        window.onload = function() {
            document.getElementById("content-mdfile").innerHTML = renderMarkdown(@json($file->content));
        }
    </script>
@endsection