@extends('layout.app')
@section('content')

    <div class="row mb-3 ">
        <div class="col-sm-1 col-3 mr-5">
            <button id="btnNewFolder" type="button" class="btn btn-dark"><i class="far fa-folder-plus"></i> New Folder
            </button>
        </div>
        <div class="col-1">
            <button id="btnRenameFolder{{$folder->id}}" name="{{$folder->id}}" value="{{$folder->name}}" type="button"
                    class="btn btn-secondary"><i
                        class="fal fa-pen"></i> Rename
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="list-group">
                <a href="javascript:;" class="list-group-item  active bg-dark">
                    <h1>{{$folder->name}}</h1>
                </a>
                @foreach($folders as $childFolder)
                    <a href="{{route('folders.show',$childFolder->id)}}" class=" list-group-item clearfix ">
                        <h3 style="display: inline;"><i class="fal fa-folder fa-fw"></i> <span>{{$childFolder->name}}</span></h3>
                        <span class="float-right">
                            <button id="btnRenameFolder{{$childFolder->id}}" name="{{$childFolder->id}}"
                                    value="{{$childFolder->name}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen"></i> Rename
                            </button>
                            <button id="btnRenameDelete{{$childFolder->id}}"
                                    value="{{$childFolder->name}}"
                                    name="{{$childFolder->id}}"
                                    class="btn  btn-danger">
                                <i class="far fa-folder-times"></i> Delete
                            </button>
                        </span>
                    </a>
                @endforeach

                @foreach($files as $file)
                    <a href="{{route('files.show', $file->id)}}" class="pl-5 list-group-item "
                       style="font-family: 'Titillium Web', sans-serif;font-size: 20px;">
                        <i class="fal fa-file fa-fw"></i>{{$file->title}}
                        <span class="float-right">
                          <select class="selectpicker">
                              <option data-icon="far fa-lock" data-subtext="Only for you" value="private"> Private</option>
                              <option data-icon="fal fa-book-open" data-subtext="Everyone can read" value="readable"> Readable</option>
                              <option data-icon="fal fa-file-edit" data-subtext="Everyone can edit" value="editable"> Editable</option>
                            </select>
                            <button id="btnRenameFile{{$file->id}}" name="{{$file->id}}" value="{{$file->tile}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen"></i> Rename
                            </button>
                            <button id="btnDeleteFile{{$file->id}}"
                                    name="{{$file->id}}"
                                    value="{{$file->tile}}" class="btn  btn-danger">
                                <i class="far fa-folder-times"></i> Delete
                            </button>
                        </span></a>
                @endforeach
            </div>
        </div>
    </div>


@endsection
@section('script')
    @include('folders.partialScripts.newFolder')
    @include('folders.partialScripts.renameFolder')
    @include('folders.partialScripts.delete')
    <script>
        $(document).ready(function () {
            onReadyNewFolder();
            onReadyRename();
            onReadyDelete();

        })
    </script>
@endsection