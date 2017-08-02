<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DurYouTube helps you find the total and average duration of any YouTube playlist.">
    <meta name="keywords" content="youtube playlist duration, youtube playlist length, youtube playlist time, youtube playlist total time, youtube playlist average duration">
    <meta name="author" content="Mohamed Elghobaty">
    <title>
        @if(isset($error)) {{ $error }} - @endif
        DurYouTube
    </title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('images/icons/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('images/icons/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('images/icons/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('images/icons/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('images/icons/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('images/icons/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('images/icons/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('images/icons/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/icons/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('images/icons/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/icons/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('images/icons/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/icons/favicon/favicon-16x16.png') }}">
    <meta name="msapplication-config" content="{{ url('images/icons/favicon/browserconfig.xml') }}"/>
    <link rel="manifest" href="{{ url('images/icons/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url('images/icons/favicon/ms-icon-144x144.png') }}'">
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

        .title a, .title a:hover, .title a:active, .title a:focus {
            text-decoration: none;
            color: inherit;
        }

        .title a .red {
            color: #bb0000;
        }

        .title a .black {
            color: #000000;
        }

        .title a:hover .red {
            color: #000000;
        }

        .title a:hover .black {
            color: #bb0000;
        }

        .title a:hover svg path {
            fill: #000000;
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

        #video-list > tbody > tr > td {
            padding: 10px 5px;
            cursor: pointer;
        }

        #video-list > tbody > tr:hover > td {
            background: rgb(232, 232, 255);
        }

        .sticky{
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="full-height">
    <div class="title m-b-md" style="text-align: center; padding: 30px 0;">
        <a href="{{ url('/') }}">
            <div style="margin:0 auto;">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 355.852 355.852" style="width: 75px; height: 75px; enable-background:new 0 0 355.852 355.852;" xml:space="preserve" width="512px" height="512px">
                    <g>
                        <path d="M184.174,178.238v-73.614h-16.662v73.614c-8.415,3.324-14.378,11.519-14.378,21.118c0,9.601,5.963,17.796,14.378,21.12   v18.029h16.662v-18.029c8.436-3.324,14.398-11.519,14.398-21.12C198.572,189.757,192.609,181.563,184.174,178.238z" fill="#bb0000"/>
                        <path d="M301.143,93.878l9.227,9.23l26.13-26.145l-38.443-38.446l-26.143,26.141l9.223,9.228l-5.227,5.242   c-23.756-19.79-53.428-32.688-85.927-35.618v-6.536h13.055V0H148.66v36.974h13.041v6.536   c-79.677,7.172-142.35,74.322-142.35,155.847c0,86.291,70.21,156.495,156.487,156.495c86.304,0,156.505-70.204,156.505-156.495   c0-38.108-13.701-73.077-36.441-100.253L301.143,93.878z M175.839,312.357c-62.307,0-112.985-50.693-112.985-113   c0-62.303,50.679-112.993,112.985-112.993c62.318,0,112.994,50.69,112.994,112.993   C288.833,261.663,238.157,312.357,175.839,312.357z" fill="#bb0000"/>
                    </g>
                </svg>
            </div>
            <span class="red">Dur</span><span class="black">You</span><span class="red">Tube</span>
        </a>
    </div>
    @yield('body')
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
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    var SECONDS_IN_MINUTE = 60;
    var SECONDS_IN_HOUR = 60 * SECONDS_IN_MINUTE;
    var SECONDS_IN_DAY = 24 * SECONDS_IN_HOUR;

    function secondsToTime(inputSeconds) {
        // extract days
        var days = Math.floor(inputSeconds / SECONDS_IN_DAY);

        // extract hours
        var hourSeconds = inputSeconds % SECONDS_IN_DAY;
        var hours = Math.floor(hourSeconds / SECONDS_IN_HOUR);

        // extract minutes
        var minuteSeconds = hourSeconds % SECONDS_IN_HOUR;
        var minutes = Math.floor(minuteSeconds / SECONDS_IN_MINUTE);

        // extract the remaining seconds
        var remainingSeconds = minuteSeconds % SECONDS_IN_MINUTE;
        var seconds = Math.ceil(remainingSeconds);

        // return the final array
        return {
            'd': parseInt(days),
            'H': parseInt(hours),
            'i': parseInt(minutes),
            's': parseInt(seconds)
        };
    }

    function formatDuration(seconds) {
        if (!seconds && seconds !== 0) {
            return '<em>N/A</em>';
        }

        var ret = secondsToTime(seconds);

        return template = "<span style='color: #bb0000; font-weight: bold;'>" + ret.d + "</span> days, "
            + "<span style='color: #bb0000; font-weight: bold;'>" + ret.H + "</span> hours, "
            + "<span style='color: #bb0000; font-weight: bold;'>" + (("0" + ret.i).slice(-2)) + "</span> minutes, "
            + "and <span style='color: #bb0000; font-weight: bold;'>" + (("0" + ret.s).slice(-2)) + "</span> seconds.";
    }

    function updateInformation(total, count) {
        $(".count").html(count.toLocaleString());
        $(".average").html(isNaN(total / count) ? 'N/A' : formatDuration(total / count));
        $(".total").html(formatDuration(total));
    }

    $(document).ready(function () {
        var count = 0;
        var total = 0;
        var excludedVideos = [];
        var excludedDuration = 0;
        var $videoList = $('#video-list > tbody');

        $videoList.on('click', 'td', function () {
            var checkbox = $(this).parent().find('input').eq(0);
            checkbox.prop("checked", !checkbox.prop("checked"));
            checkbox.trigger('change');
        });

        $videoList.on('change', 'input', function () {
            var id = $(this).data('videoId');
            var index = excludedVideos.indexOf(id);
            if (this.checked && index !== -1) {
                excludedVideos.splice(index, 1);
                excludedDuration -= $(this).data('duration');
            }
            if (!this.checked && index === -1) {
                excludedVideos.push(id);
                excludedDuration += $(this).data('duration');
            }
            updateInformation(total - excludedDuration, count - excludedVideos.length);
        });

        if (typeof playlistId !== 'undefined') {
            $.get('{{ url('/process') }}/' + playlistId, function (data) {
                $("#loading").hide();
                if (data.error) {
                    $("#error").html(data.error.body).show();
                    $("#form").find("input[name=url]").val(playlistId);
                    $("#form").show();
                    document.title = data.error.title + ' - DurYouTube';
                    return;
                }

                for (var id in data.videos) {
                    if (data.videos.hasOwnProperty(id)) {
                        total += data.videos[id].duration;
                        count++;
                        $videoList.append(
                            '<tr>' +
                            '<td><input checked type="checkbox" data-video-id="' + id + '" data-duration="' + data.videos[id].duration + '" /></td>' +
                            '<td>' + data.videos[id].name + '</td>' +
                            '<td>' + formatDuration(data.videos[id].duration) + '</td>' +
                            '</tr>'
                        )
                    }
                }
                updateInformation(total, count);
                $("#title").text(data.playlist.title);
                $("#title").attr('href', "https://www.youtube.com/playlist?list=" + playlistId);
                $("#image").attr('src', data.playlist.image.url);
                $(".results").show();
                document.title = data.playlist.title + ' - DurYouTube';
                $(window).bind("scroll", function () {
                    if ($(this).scrollTop() > 100) {
                        $("#float-summary").fadeIn();
                    } else {
                        $("#float-summary").fadeOut();
                    }
                });
            });

        }
    });
</script>
</body>
</html>
