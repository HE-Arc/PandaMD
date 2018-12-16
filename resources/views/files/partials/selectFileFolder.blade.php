@changeable($file)
<select style="font-family: Nunito,FontAwesome" id="selectedFile{{$file->id}}" name="newFolder" title="{{$file->id}}"
        class="custom-select mr-1">

    @foreach($treeFolders as $childFolder)
        @if($childFolder[0]->id == $file->folder_id)
            <option id="folder{{$childFolder[0]->id}}" value="{{$childFolder[0]->id}}" class="font-weight-bold "
                    selected>{!! str_repeat('&nbsp;',($childFolder[1])*6); !!}&#xf07c {{$childFolder[0]->name}}
            </option>
        @else
            <option id="folder{{$childFolder[0]->id}}"
                    value="{{$childFolder[0]->id}}">{!! str_repeat('&nbsp;',($childFolder[1])*6); !!}
                &#xf07b {{$childFolder[0]->name}}</option>
        @endif
    @endforeach
</select>
@endchangeable
