@extends('layout.app')

@section('content')
    <form method="POST" action="{{route('files.update', $file)}}">
        {{ csrf_field() }}
        @method('PATCH')
        <div class="text-center mb-2">
            <a id="optionsToggler" class="btn btn-outline-info" data-toggle="collapse" href="#pandocOptions"
               role="button"
               aria-expanded="true" aria-controls="pandocOptions">Reduce Pandoc options</a>

        </div>

        <div class="collapse show mb-2" id="pandocOptions">
            <div class="p-2 border">
                <div class="form-group row pl-3">
                    @foreach($cbxOptions as $cbxOption)
                        <div class="form-check custom-checkbox col-6 col-lg-3">
                            <input id="{{$cbxOption[0]}}" name="{{$cbxOption[0]}}" value="true" type="checkbox"
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
                            <input id="{{$textOption[0]}}" name="{{$textOption[0]}}" type="text"
                                   value="{{$textOption[2]}}" placeholder="{{$textOption[3]}}"
                                   title="{{$textOption[3]}}" class="form-control" {{$textOption[4]}}>
                        </div>
                    </div>
                @endforeach
                <div class="form-group row">
                    <label for="date" class="col-form-label col-sm-2">Date</label>
                    <div class="col-sm-10">
                        <input id="date" name="date" type='text' class="form-control datepicker-here"
                               data-position="left top" data-language='en'
                               data-date-format="dd/mm/yyyy" onkeydown="return false"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectedFile{{ $file->id }}" class="col-form-label col-sm-2">Location</label>
                    <div class="col-sm-10">
                        @include('files.partials.selectFileFolder')
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectRight{{ $file->id }}" class="col-form-label col-sm-2">Security</label>
                    <div class="col-sm-10">
                        @include('files.partials.selectRight')
                    </div>
                </div>
            </div>

        </div>

        <textarea name="fileContent" id="editor-md"></textarea>
        {{--Button submit in toolbar from js--}}
    </form>

@endsection
@section('script')
    <script>
        $(document).ready(function () {

        })
    </script>
    <script>

        cancelUrl = "{{ route('files.show', $file->id) }}";
        var mdeditor = initSimpleMde(@json($fileContent));

        var datepicker = $('#date').datepicker({
            'autoClose': true
        }).data('datepicker');
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
            verifyCbx();
        };

        function verifyCbx() {
            elem = document.getElementById('isTocOwnPage');
            elem.disabled = !elemToVerify.checked;
            if (elem.disabled) {
                elem.parentElement.classList.add("cbxdisabled");
            } else {
                elem.parentElement.classList.remove("cbxdisabled");
            }
        };
        $(function () {
            $(document).tooltip();
        });



        window.addEventListener("dragover", function (e) {
            e.preventDefault();
        });

        window.addEventListener("drop", function (e) {
            e.preventDefault();
        });


        mdeditor.codemirror.on("paste", function (data, e) {
            getFileTransferData(data, e);
        });

        mdeditor.codemirror.on("drop", function(data, e){
            getFileTransferData(data, e);
            mdeditor.codemirror.replaceRange(' **Uploading image...** ', {line: Infinity});
        });

        let urlGetImgurURL = "{{route("uploadImage")}}";
        function getFileTransferData(data, e){
            let files = e.dataTransfer.files;
            if(files.length > 0){
                let file = files[0];
                fetch(urlGetImgurURL, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: file
                }).then(response => {
                    let jsonData = response.json();
                    jsonData.then( jsonData => {
                        console.log(jsonData.link);
                        mdeditor.codemirror.undo();
                        mdeditor.codemirror.replaceRange(' ![](' + jsonData.link + ') ', {line: Infinity});
                    })
                })
            }
        }
        verifyCbx();
    </script>
@endsection
