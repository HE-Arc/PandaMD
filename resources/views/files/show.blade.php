@extends('layout.app')
@section('content')

    <h1>{{$file->title}}
        <div class="float-right">
            <button onclick="generatePdf('{{route('generate', $file)}}')" class="btn btn-outline-secondary mr-2">
                Generate PDF
            </button>
            @editable($file)<a href="{{route('files.edit', $file)}}" class="btn btn-outline-primary"><i
                        class="fal fa-edit fa-fw"></i> edit</a>@endeditable
        </div>
    </h1>
    <div id="content-mdfile" class="border-top pt-4">

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