<select class="selectpicker customselect">
    <option data-icon="far fa-lock" data-subtext="Only for you" value="private" @if($file->security=='private')selected @endif> Private</option>
    <option data-icon="fal fa-book-open" data-subtext="Everyone can read" value="readable" @if($file->security=='readable')selected @endif> Readable</option>
    <option data-icon="fal fa-file-edit" data-subtext="Everyone can edit" value="editable" @if($file->security=='editable')selected @endif> Editable</option>
</select>

