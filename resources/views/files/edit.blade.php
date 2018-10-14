@extends('layout.app')

@section('content')
    <form method="POST" action="{{route('files.update', $file)}}">
        {{ csrf_field() }}
        @method('PATCH')
        <textarea name="fileContent" id="editor-md"></textarea>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
    <script>
        initSimpleMde(@json($file->content));
    </script>
@endsection