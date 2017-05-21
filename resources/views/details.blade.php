@extends('layout')
@section('body')
    <table style="width: 50%; margin: 0 auto; text-align: center; border: 1px solid grey;" cellpadding="10">
        <tbody>
        <tr>
            <td style="vertical-align: middle">
                <img src="{{ asset('images/icons/youtube-play-button.svg') }}" style="height: 40px"/>
            </td>
            <td style="vertical-align: middle; text-align: left;">
                Total Videos
            </td>
            <td style="vertical-align: middle; color: #bb0000; font-weight: bold;">
                {{ number_format($count) }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle">
                <img src="{{ asset('images/icons/chronometer.svg') }}" style="height: 40px"/>
            </td>
            <td style="vertical-align: middle; text-align: left;">
                Total Duration
            </td>
            <td style="vertical-align: middle">
                {!! $formattedTotal !!}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle">
                <img src="{{ asset('images/icons/chronometer-outline.svg') }}" style="height: 40px"/>
            </td>
            <td style="vertical-align: middle;  text-align: left;">
                Average Duration
            </td>
            <td style="vertical-align: middle">
                {!! $formattedAverage !!}
            </td>
        </tr>
        </tbody>
    </table>
@endsection