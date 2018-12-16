@extends('layout.app')

@section('content')
    <div class="col-sm-12 justify-content-center" id="hero">
        <img src="{{asset('images/homepage_1.svg')}}">
    </div>
    <div class="row justify-content-center col-sm-14">
        <div class="card-group">
            <div class="col-sm">
                <div class="card bg-light">
                    <img class="card-img-top" src="{{asset('images/MD_TO_PDF.png')}}">
                    <div class="card-body">
                        <h5 class="card-title">Convert markdown to PDF</h5>
                        <p class="card-text">
                            Convert your markdown files to PDF without installing anything. Just upload your file,
                            select the options you want and let our server run pandoc for you.
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-sm">
                <div class="card bg-light">
                    <img class="card-img-top" src="{{asset('images/edit_demo2.png')}}">
                    <div class="card-body">
                        <h5 class="card-title">Write, save and edit online</h5>
                        <p class="card-text">
                            Our built-in editor allows you to take notes directly on
                            our website, and access them from anywhere.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card bg-light">
                    <img class="card-img-top" src="{{asset('images/share_1.png')}}">
                    <div class="card-body">
                        <h5 class="card-title">Share your notes</h5>
                        <p class="card-text">
                            Thanks to our file system, you can share your notes exactly
                            the way you like: keep them private, allow read only or full edition.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

