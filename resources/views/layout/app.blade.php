<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/all.js')}}"></script>
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/gif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.5.1/katex.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/github-markdown-css/2.2.1/github-markdown.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-POYwD7xcktv3gUeZO5s/9nUbRJG/WOmV6jfEGikMJu77LGYO8Rfs2X7URG822aum" crossorigin="anonymous">
    @yield("includes")
    <title>PandaMD</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-family:'Comfortaa'">
    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('favicon.ico')}}" alt=""> PandaMD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{{ (Request::is('/') ? 'active' : '') }}}">
                <a class="nav-link" href="{{route('home')}}"><i class="fal fa-home fa-fw"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{{ (Request::is('folders/*') ? 'active' : '') }}}"
                   href="{{route('folders.index')}}"><i
                            class="fal fa-folder fa-fw"></i> Folder</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fal fa-pencil fa-fw"></i> Create</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i
                                class="fal fa-sign-in fa-fw"></i> {{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}"><i
                                    class="fal fa-user-plus fa-fw"></i> {{ __('Register') }}</a>
                    @endif
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fal fa-user fa-fw"></i> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fal fa-sign-out fa-fw"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div id="divAlert"></div>
    @yield('content')

</div>
@yield('script')
<script>
    function createAlert(alertType, alertText, linkHref = "", linkText = "") {
        $(".alert").alert('close');
        if (typeof alertTimeout !== 'undefined') {
            clearTimeout(alertTimeout);
        }
        let divAlert = document.getElementById("divAlert");
        let alert = document.createElement("div");
        alert.classList.add("alert", alertType, "alert-dismissible", "fade");
        let btn = document.createElement("button");
        btn.classList.add("close");
        btn.setAttribute("data-dismiss", "alert");
        btn.setAttribute("aria-label", "Close");
        let cross = document.createElement("span");
        cross.setAttribute("aria-hidden", "true");
        cross.appendChild(document.createTextNode("x"));
        btn.appendChild(cross);
        alert.appendChild(document.createTextNode(alertText));
        let link = document.createElement("a");
        link.setAttribute("href", linkHref);
        link.appendChild(document.createTextNode(linkText));
        link.classList.add("alert-link");
        link.addEventListener("click", function(event) {
            $('.alert').alert('close');
        })
        alert.appendChild(link);
        alert.appendChild(btn);
        divAlert.appendChild(alert);
        alertTimeout = setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
        $(document).ready(function () {
            $(".alert").addClass('show');
        });
    }

    @if(Request::get('error')==1)
    createAlert("alert-danger", "You are not allowed to acceess to this ressource");
    @elseif(Request::get('error')==2)
    createAlert("alert-danger", "File is missing");
    @endif
</script>
</body>
</html>