@extends('layout.app')
@section('content')

    <div class="row text-secondary" style="font-size: 30pt;">
        <div class="col">
            @foreach($folderPath as $folder)
                <a href="{{ route('folders.show', $folder->id) }}"
                   class="text-secondary">{{ $folder->name }}</a><span
                        style="margin-right:-10px;">/</span>
            @endforeach
            {{ $file->title }}
        </div>
        <div class="col-auto">
            <button onclick="generatePdf('{{route('generate', $file)}}')" class="btn btn-outline-secondary mr-2">
                <i class="fal fa-download fa-fw"></i><span class="d-none d-md-inline"> Generate PDF</span>
            </button>
            @editable($file)<a href="{{route('files.edit', $file)}}" class="btn btn-outline-primary"><i
                        class="fal fa-edit fa-fw"></i><span class="d-none d-md-inline"> edit</span></a>@endeditable
        </div>
    </div>
    <div id="content-mdfile" class="border-top pt-4">
        {{--Content come from JS--}}
    </div>
@endsection
@section('script')
    <script>
        var urlDownloadPdfFile;
        var urlGeneratePdfFile;
        var urlDownloadPdfFileOriginal;
        var urlGeneratePdfFileOriginal;
        var token = 0;
        window.onload = function () {
            document.getElementById("content-mdfile").innerHTML = renderMarkdown(@json($file->content??""));
            urlDownloadPdfFileOriginal = "{{route("downloadPdfFile", "token")}}";
            urlGeneratePdfFileOriginal = "{{route("isReady", "token")}}";
        };

        function generatePdf(url) {
            fetch(url, {
                method: "GET"
            }).then(response => {
                return response.text();
            }).then(value => {
                token = value;
                urlDownloadPdfFile = urlDownloadPdfFileOriginal.replace("token", token);
                urlGeneratePdfFile = urlGeneratePdfFileOriginal.replace("token", token);
                createAlert('alert-secondary', 'File is generating');
                tryGetPdfFile();
            });

        }

        function tryGetPdfFile() {
            fetch(urlGeneratePdfFile, {
                method: "GET"//,
            }).then(response => {
                if (response.ok) {
                    response.text().then(function (value) {
                        if (value == 1) {
                            createAlert('alert-primary', 'Document is ready : ', urlDownloadPdfFile, 'download');
                            token = 0;
                        } else if (value == -1) {
                            createAlert('alert-danger', 'An error occured, please verify your files');
                            token = 0;
                        } else {
                            setTimeout(tryGetPdfFile, 100);
                        }
                    });
                } else {
                    urlDownloadPdfFile = urlDownloadPdfFileOriginal.replace("token", token);
                    urlGeneratePdfFile = urlGeneratePdfFileOriginal.replace("token", token);
                }
            });
        }

    </script>
@endsection