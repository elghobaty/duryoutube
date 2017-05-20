@extends('layout')
@section('body')
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
@endsection
