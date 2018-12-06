@extends('layout.app')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="list-group">
                <div class="row mx-0 darkBackground border border-dark rounded text-secondary" style="font-size: 30pt;">
                    <div class="col">
                        @foreach($folderPath as $folder)
                            <a href="{{ route('folders.show', $folder->id) }}" class="text-secondary">{{ $folder->name }}</a>@if(!$loop->last)<span style="margin-right:-10px;">/</span>@endif
                        @endforeach
                    </div>
                    <div id="btnNewFolder" class="col-auto actionToHover text-center">
                            <i class="far fa-plus fa-fw py-2"></i>
                    </div>
                </div>

                @foreach($folders as $childFolder)
                    <a href="{{route('folders.show',$childFolder->id)}}" class=" list-group-item clearfix ">
                        <h3 style="display: inline;"><i class="fal fa-folder fa-fw"></i> <span
                                    class="folder{{$childFolder->id}}">{{$childFolder->name}}</span></h3>
                        <span class="float-right">
                            @include('folders.partials.selectFolderFolder')
                            <button id="btnRenameFolder{{$childFolder->id}}"
                                    value="{{$childFolder->id}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen fa-fw"></i><span class="d-none d-lg-inline"> Rename</span>
                            </button>
                            <button id="btnDeleteFolder{{$childFolder->id}}"
                                    value="{{$childFolder->name}}"
                                    name="{{$childFolder->id}}"
                                    class="btn  btn-danger">
                                <i class="far fa-folder-times fa-fw"></i><span class="d-none d-lg-inline"> Delete</span>
                            </button>
                        </span>
                    </a>
                @endforeach

                @foreach($files as $file)
                    <a href="{{route('files.show', $file->id)}}" class="pl-5 list-group-item "
                       style="font-family: 'Titillium Web', sans-serif;font-size: 20px;">
                        <i class="fal fa-file fa-fw"></i> <span class="file{{$file->id}}">{{$file->title}}</span>
                        <span class="float-right">
                            @include('files.partials.selectFileFolder')
                            <button id="btnRenameFile{{$file->id}}" value="{{$file->id}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen fa-fw"></i><span class="d-none d-lg-inline"> Rename</span>
                            </button>
                            <button id="btnDeleteFile{{$file->id}}"
                                    name="{{$file->id}}"
                                    value="{{$file->title}}" class="btn  btn-danger">
                                <i class="far fa-file fa-fw"></i><span class="d-none d-lg-inline"> Delete</span>
                            </button>
                        </span></a>
                @endforeach
            </div>
        </div>
    </div>


@endsection
@section('script')
    @include('folders.partialScripts.newFolder')
    @include('folders.partialScripts.renameFileFolder')
    @include('folders.partialScripts.delete')
    @include('files.partialScripts.selectFileFolder')
    @include('folders.partialScripts.selectFolderFolder')
    <script>
        $(document).ready(function () {
            onReadyNewFolder();
            onReadyRename('btnRenameFolder', "{{route('folders.update',':id')}}", "folder");
            onReadyRename('btnRenameFile', "{{route('changeFileName',':id')}}", "file");
            onReadyDelete('btnDeleteFolder', "{{route('folders.destroy',':id')}}");
            onReadyDelete('btnDeleteFile', "{{route('files.destroy',':id')}}");
            onReadyRename('btnRenameFolder',"{{route('folders.update',':id')}}","folder");
            onReadyRename('btnRenameFile',"{{route('changeFileName',':id')}}","file");
            onReadyDelete('btnDeleteFolder',"{{route('folders.destroy',':id')}}","folder");
            onReadyDelete('btnDeleteFile',"{{route('files.destroy',':id')}}","file");

            OnreadyChangeFileFolder();
            OnreadyChangeFolderFolder();
        })
    </script>
@endsection