<select id="selectedFolder{{$childFolder->id}}" name="{{$childFolder->id}}" class="selectpicker customselect">

    @foreach($treeFolders as $childTreeFolder)
        @if($childTreeFolder[0]->id == $childFolder->folder_id)
            <option id="folder{{$childTreeFolder[0]->id}}" value="{{$childTreeFolder[0]->id}}" class="font-weight-bold "
                    selected>{!! str_repeat('&nbsp;',($childTreeFolder[1])*6); !!}&#xf07b {{$childTreeFolder[0]->name}}
            </option>
        @else
            <option id="folder{{$childTreeFolder[0]->id}}"
                    value="{{$childTreeFolder[0]->id}}">{!! str_repeat('&nbsp;',($childTreeFolder[1])*6); !!}
                &#xf114 {{$childTreeFolder[0]->name}}</option>
        @endif
    @endforeach
</select>
