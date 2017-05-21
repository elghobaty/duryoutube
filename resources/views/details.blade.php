@extends('layout')
@section('body')
    <script>
        var playlistId = '{{ $playlistId }}';
    </script>

    <div style="text-align: center; width: 50%; margin: 0 auto;">
        <div id="loading">
            <img src="{{ asset('images/icons/loading.svg') }}" style="width: 70px"/>
        </div>

        <div class="warning" style="display: none" id="error">
        </div>

        <form method="get" id="form" style="display: none">
            <input type="text" name="url" placeholder="Youtube Playlist URL or ID" class="search"/>
            <br/>
            <input type="submit" value="Try Again" class="submit"/>
        </form>

        <div id="results" style="display: none">
            <h2>
                <a href="" target="_blank" id="title"></a>
            </h2>
            <img src="" id="image" />
            <br />
            <br />
            <table style="width: 100%; margin: 0 auto; text-align: center; border: 1px solid grey;" cellpadding="5">
                <tbody>
                <tr>
                    <td style="vertical-align: middle">
                        <img src="{{ asset('images/icons/youtube-play-button.svg') }}" style="height: 40px"/>
                    </td>
                    <td style="vertical-align: middle; text-align: left;">
                        Total Videos
                    </td>
                    <td style="vertical-align: middle; color: #bb0000; font-weight: bold;" id="count">
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <img src="{{ asset('images/icons/chronometer.svg') }}" style="height: 40px"/>
                    </td>
                    <td style="vertical-align: middle; text-align: left;">
                        Total Duration
                    </td>
                    <td style="vertical-align: middle" id="total">
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <img src="{{ asset('images/icons/chronometer-outline.svg') }}" style="height: 40px"/>
                    </td>
                    <td style="vertical-align: middle;  text-align: left;">
                        Average Duration
                    </td>
                    <td style="vertical-align: middle" id="average">
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>

@endsection