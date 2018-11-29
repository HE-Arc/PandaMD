@changeable($file)
<div class="dropdown">
    <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Directory
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach($user->folders as $childFolder)
            @if($childFolder->id == $file->folder_id)
                <a id="folder{{$childFolder->id}}" name="{{$file->id}}" value="{{$childFolder->id}}" class="dropdown-item " href="javascript:;"><span class="font-weight-bold"><i class="fas fa-folder"></i> {{$childFolder->name}} <i
                            class="far fa-check"></i></span></a>
            @else
                <a id="folder{{$childFolder->id}}" name="{{$file->id}}" value="{{$childFolder->id}}" class="dropdown-item" href="javascript:;"><i class="fal fa-folder fa-fw"></i> {{$childFolder->name}}</a>
            @endif
        @endforeach
    </div>
</div>
@endchangeable