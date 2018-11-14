@extends('layout.app')
@section('content')

    <h1>{{$file->title}} <div class="float-right"><button onclick="generatePdf('{{route('generate', $file)}}')" class="btn btn-outline-secondary mr-2">Generate
            PDF</button>@editable($file)<a href="{{route('files.edit', $file)}}" class="btn btn-outline-primary"><i
                    class="fal fa-edit fa-fw"></i> edit</a>@endeditable
        </div></h1>
    <div id="content-mdfile" class="border-top pt-4">

    </div>
    <script>
        window.onload = function() {
            document.getElementById("content-mdfile").innerHTML = renderMarkdown(@json($file->content));
            urlDownloadPdfFile = "{{route("downloadPdfFile", "token")}}";
            urlGeneratePdfFile = "{{route("isReady", "token")}}";
        };

        function generatePdf(url) {
            fetch(url, {
                method: "GET"//,
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                response.json().then(function(value) {
                    token = value;
                    urlDownloadPdfFile = urlDownloadPdfFile.replace("token", token);
                    urlGeneratePdfFile = urlGeneratePdfFile.replace("token", token);
                    createAlert('alert-secondary', 'File is generating');
                    tryGetPdfFile();
                });
            });
        }

        function tryGetPdfFile() {
            fetch(urlGeneratePdfFile, {
                method: "GET"//,
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                response.json().then(function(value) {
                    if(value == 1) {
                        createAlert('alert-primary', 'Document is ready : ', urlDownloadPdfFile, 'download');
                        urlDownloadPdfFile = urlDownloadPdfFile.replace(token, "token");
                        urlGeneratePdfFile = urlGeneratePdfFile.replace(token, "token");
                    } else if(value == -1) {
                        createAlert('alert-danger', 'An error occured, please verify your files');
                        urlDownloadPdfFile = urlDownloadPdfFile.replace(token, "token");
                        urlGeneratePdfFile = urlGeneratePdfFile.replace(token, "token");
                    }
                    else {
                        setTimeout(tryGetPdfFile, 100);
                    }
                });
            });
        }

    </script>
@endsection