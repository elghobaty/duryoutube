@extends('layout')
@section('body')
    <div style="text-align: center; width: 50%; margin: 0 auto;">
        <h1>Total Videos: <strong style="color: #334dff;">{{ $count }}</strong></h1>
        @if($count)
            <h1>Total Duration: <strong>{!! $formattedTotal !!}</strong></h1>
            <h1>Average Duration: <strong>{!! $formattedAverage !!}</strong></h1>
        @endif
    </div>
@endsection