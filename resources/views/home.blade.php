<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DurYouTube helps you find the duration of any YouTube playlist.">
    <title>@if($title){{ $title }} - @endif DurYouTube</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/image/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/image/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/image/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('/image/icons/manifest.json') }}">
    <link rel="mask-icon" href="{{ url('/image/icons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Oswald," rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: 0;
            font-size: 18px;
        }

        .full-height {
            height: 100vh;
        }

        .title {
            font-family: 'Oswald', cursive;
            font-size: 40px;
            padding: 0 120px;
        }

        .m-b-md {
            margin-bottom: 20px;
        }

        a, a:hover, a:active, a:focus {
            color: inherit;
            text-decoration: none;
        }

        input.search {
            display: block;
            font-size: 18px;
            margin: 0 auto;
            width: 100%;
            font-family: sans-serif;
            box-shadow: none;
            border-radius: 0;
            padding: 15px 10px;
            border: solid 5px #bb2d2d;
            -webkit-transition: all 500ms;
            -moz-transition: all 500ms;
            -o-transition: all 500ms;
            transition: all 500ms;
        }

        input.search:focus {
            border: solid 5px #bb0000;
            outline: none;
            -webkit-transition: all 500ms;
            -moz-transition: all 500ms;
            -o-transition: all 500ms;
            transition: all 500ms;
        }

        .submit {
            cursor: pointer;
            padding: 15px 40px;
            border-color: #bb2d2d;
            border-radius: 0;
            font-size: 18px;
            color: #fff;
            background-color: #bb2d2d;
            text-transform: uppercase;
            -webkit-transition: all 500ms;
            -moz-transition: all 500ms;
            -o-transition: all 500ms;
            transition: all 500ms;
        }

        .submit:hover {
            margin-left: 0;
            border-color: #bb0000;
            border-radius: 0;
            color: #fff;
            background-color: #bb0000;
            -webkit-transition: all 500ms;
            -moz-transition: all 500ms;
            -o-transition: all 500ms;
            transition: all 500ms;
        }

        .submit:focus {
            outline: none;
            color: #ffffff;
            -webkit-transition: all 500ms;
            -moz-transition: all 500ms;
            -o-transition: all 500ms;
            transition: all 500ms;
        }

        .info, .success, .warning, .error {
            margin: 10px 50px 30px;
            padding: 20px;
            font-weight: bold;
        }

        .info {
            color: #00529B;
            background-color: #BDE5F8;
        }

        .success {
            color: #4F8A10;
            background-color: #DFF2BF;
        }

        .warning {
            color: #9F6000;
            background-color: #FEEFB3;
        }

        .error {
            color: #D8000C;
            background-color: #FFBABA;
        }

        .info i, .success i, .warning i, .error i {
            margin: 10px 22px;
            font-size: 2em;
            vertical-align: middle;
        }

    </style>
</head>
<body>
<div class="full-height">
    <div class="title m-b-md" style="text-align: center; padding: 40px 0 100px;">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/icons/stop-clock.svg') }}" style="max-width: 75px; display: block; margin:0 auto;"/>
            <span style="color:#bb0000">Dur</span>You<span style="color:#bb0000">Tube</span>
        </a>
    </div>
    <div style="text-align: center; width: 50%; margin: 0 auto;">
        @if($error)
            <div class="warning">
                {!! $error !!}
            </div>
        @endif
        <form method="get">
            <input type="text" value="{{ request('url') }}" name="url" placeholder="Youtube Playlist URL or ID" class="search"/>
            <br/>
            <input type="submit" value="Submit" class="submit"/>
        </form>
    </div>
</div>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', '{{ config('services.analytics.code') }}', 'auto');
    ga('send', 'pageview');
</script>

</body>
</html>
