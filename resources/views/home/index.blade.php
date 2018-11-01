@extends('layout.app')

@section('content')
    @if(Request::get('error')==1)<div class="alert alert-danger alert-dismissible fade" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>You are not allowed to access to this file</strong>
    </div>@endif
    <h1>Home</h1>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(".alert").addClass('show');
        });
        setTimeout(function(){
            $(".alert").alert("close");
        },5000);
    </script>
@endsection