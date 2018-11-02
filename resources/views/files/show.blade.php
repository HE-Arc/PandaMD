@extends('layout.app')

@section('content')

    <h1>{{$file->title}} <div class="float-right"><a href="{{route('generate', $file)}}" class="btn btn-outline-secondary mr-2">Generate
            PDF</a>@editable($file)<a href="{{route('files.edit', $file)}}" class="btn btn-outline-primary"><i
                    class="fal fa-edit fa-fw"></i> edit</a>@endeditable
        </div></h1>
    <div id="content-mdfile" class="border-top pt-4">

    </div>
    <script>
        window.onload = function() {
            document.getElementById("content-mdfile").innerHTML = renderMarkdown(@json($file->content));
        }
    </script>
@endsection