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

        <div class="results" style="display: none">
            <h2>
                <a href="" target="_blank" id="title"></a>
            </h2>
            <img src="" id="image"/>
            <br/>
            <br/>
        </div>
    </div>

    <div class="results" style="display: none; text-align: center;width: 80%; margin: 20px auto 200px;">

        {{--@todo: Sticky thead--}}
        {{--@todo: when deselected, apply strikethrough css to the whole row --}}
        <h4 class="warning">Click a video to exclude it from the duration calculations.</h4>
        <table border="1" style="width: 100%;" id="video-list">
            <thead>
            <tr>
                <th colspan="3">
                    <table style="width: 100%;margin: 0 auto; text-align: center; background-color: rgb(232, 232, 255)" cellpadding="5">
                        <tbody>
                        <tr>
                            <td style="vertical-align: middle">
                                <img src="{{ asset('images/icons/youtube-play-button.svg') }}" style="height: 40px"/>
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                Total Videos
                            </td>
                            <td style="vertical-align: middle; color: #bb0000; font-weight: bold;">
                                <span class="count"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">
                                <img src="{{ asset('images/icons/chronometer.svg') }}" style="height: 40px"/>
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                Total Duration
                            </td>
                            <td style="vertical-align: middle" class="total">
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">
                                <img src="{{ asset('images/icons/chronometer-outline.svg') }}" style="height: 40px"/>
                            </td>
                            <td style="vertical-align: middle;  text-align: left;">
                                Average Duration
                            </td>
                            <td style="vertical-align: middle" class="average">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>

            </tfoot>
        </table>


        <table style="display: none;text-align: center; background-color: rgb(232, 232, 255); border: 1px solid rgb(135, 135, 236); position: fixed; bottom: 5px; right: 5px;" cellpadding="5" id="float-summary">
            <tbody>
            <tr>
                <td style="vertical-align: middle">
                    <img src="{{ asset('images/icons/youtube-play-button.svg') }}" style="height: 40px"/>
                </td>
                <td style="vertical-align: middle; text-align: left;">
                    Total Videos
                </td>
                <td style="vertical-align: middle; color: #bb0000; font-weight: bold;">
                    <span class="count"></span>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle">
                    <img src="{{ asset('images/icons/chronometer.svg') }}" style="height: 40px"/>
                </td>
                <td style="vertical-align: middle; text-align: left;">
                    Total Duration
                </td>
                <td style="vertical-align: middle" class="total">
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle">
                    <img src="{{ asset('images/icons/chronometer-outline.svg') }}" style="height: 40px"/>
                </td>
                <td style="vertical-align: middle;  text-align: left;">
                    Average Duration
                </td>
                <td style="vertical-align: middle" class="average">
                </td>
            </tr>
            </tbody>
        </table>

    </div>


@endsection