@extends('layout.app')
@section("includes")

@endsection
@section('content')
    <form method="POST" action="{{route('files.update', $file)}}">
        {{ csrf_field() }}
        @method('PATCH')
        <div class="text-center mb-2">
            <a id="optionsToggler" class="btn btn-outline-info" data-toggle="collapse" href="#pandocOptions"
               role="button"
               aria-expanded="true" aria-controls="pandocOptions">Reduce Pandoc options</a>
        </div>
        <div class="collapse show border p-2 mb-2" id="pandocOptions">
            <div class="form-group row pl-3">
                @foreach($cbxOptions as $cbxOption)
                    <div class="form-check custom-checkbox col-6 col-lg-3">
                        <input id="{{$cbxOption[0]}}" name="{{$cbxOption[0]}}" type="checkbox"
                               class="custom-control-input"
                               @if($cbxOption[2])checked="checked"@endif>
                        <label for="{{$cbxOption[0]}}"
                               class="custom-control-label">{{$cbxOption[1]}}</label>
                    </div>
                @endforeach
            </div>
            @foreach($textOptions as $textOption)
                <div class="form-group row">
                    <label for="{{$textOption[0]}}"
                           class="col-sm-2 col-form-label">{{$textOption[1]}}</label>
                    <div class="col-sm-10">
                        <input id="{{$textOption[0]}}" name="{{$textOption[0]}}" type="text" value="{{$textOption[2]}}"
                               class="form-control">
                    </div>
                </div>
            @endforeach

            <div class="form-group row">
                <label for="date" class="col-form-label col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                    <input id="date" name="date" type='text' class="form-control datepicker-here"
                           data-position="left top" data-language='en'
                           data-date-format="dd/mm/yyyy" onchange="console.log(datepicker.date)"/>
                </div>
            </div>

        </div>
        <textarea name="fileContent" id="editor-md"></textarea>

        <button type="submit" class="btn btn-outline-primary"><i class="fal fa-save fa-fw"></i> Save</button>

    </form>
    <script>
        initSimpleMde(@json($file->content));

        var datepicker = $('#date').datepicker().data('datepicker');
        datepicker.selectDate(new Date("{{$fileDate}}"));

        var optionsToggler = $("#optionsToggler");
        optionsToggler.on("click", function () {
            if ($("#pandocOptions").hasClass("show")) {
                optionsToggler.text(optionsToggler.text().replace("Reduce", "Show"));
            } else {
                optionsToggler.text(optionsToggler.text().replace("Show", "Reduce"));
            }
        });

        var elemToVerify = document.getElementById('isToc');
        elemToVerify.onchange = function () {
            elem = document.getElementById('isTocOwnPage');
            elem.disabled = !elemToVerify.checked;
            if (elem.disabled) {
                elem.parentElement.classList.add("cbxdisabled");
            } else {
                elem.parentElement.classList.remove("cbxdisabled");
            }
        };
    </script>
@endsection