@extends('layout.app')
@section('inculdes')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="row mb-3 ">
        <div class="col-sm-1 col-3 mr-5">
            <button id="btnNewFolder" type="button" class="btn btn-dark"><i class="far fa-folder-plus"></i> New Folder
            </button>
        </div>
        <div class="col-1">
            <button id="btnRenameFolder{{$folder->id}}" name="{{$folder->id}}" value="{{$folder->name}}" type="button" class="btn btn-secondary"><i
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
                        <h3 style="display: inline;"><i class="fal fa-folder fa-fw"></i> {{$childFolder->name}}</h3>
                        <span class="float-right">
                            <button id="btnRenameFolder{{$childFolder->id}}" name="{{$childFolder->id}}" value="{{$childFolder->name}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen"></i> Rename
                            </button>
                            <button class="btn  btn-danger">
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
                            <button id="btnRenameFile{{$file->id}}" name="{{$file->id}}" value="{{$file->tile}}"
                                    class="btn  btn-secondary">
                                <i class="fal fa-pen"></i> Rename
                            </button>
                            <button class="btn  btn-danger">
                                <i class="far fa-folder-times"></i> Delete
                            </button>
                        </span></a>
                @endforeach
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>

        var OnReady = (function () {
            var onReadyNewFolder = function () {
                $('#btnNewFolder').click(function (event) {
                    event.preventDefault()
                    swal({
                        title: 'Rename your new Folder',
                        input: 'text',
                        inputValue:'Untilted' ,
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Create',
                        showLoaderOnConfirm: true,
                        preConfirm: (folderName) => {
                            return fetch('{{route('folders.store')}}', {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },

                                body: JSON.stringify({name: folderName, folderId: "{{$folder->id}}"})
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json();
                            })
                                .catch(error => {
                                    swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                })
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    }).then((result) => {
                        swal(
                            'Folder Created',
                            `${result.value.name}`,
                            'success'
                        ).then(function () {
                            location.reload();
                        });

                    })
                })
            }
            var onReadyRename = function () {
                $("button[id^='btnRenameFolder']").click(function (event) {
                    let value=$(this).val();
                    let id=$(this).attr("name");
                    event.preventDefault();
                    swal({
                        title: 'Rename Folder: "'+value+'"',
                        input: 'text',
                        inputValue: value,
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Rename',
                        showLoaderOnConfirm: true,
                        preConfirm: (folderName) => {
                            return fetch('{{url('/folders')}}'+'/'+id, {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },

                                body: JSON.stringify({newName: folderName})
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json();
                            })
                                .catch(error => {
                                    swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                })
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    }).then((result) => {
                        swal(
                            'Folder Rename',
                            `${result.value.newName}`,
                            'success'
                        ).then(function () {
                            location.reload();
                        });

                    })

                })
            }

            return {
                onReadyNewFolder: onReadyNewFolder,
                onReadyRename: onReadyRename
            }

        })()


        $(document).ready(function () {
            OnReady.onReadyNewFolder();
            OnReady.onReadyRename();

        })
    </script>
@endsection