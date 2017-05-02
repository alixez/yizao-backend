@extends('layouts.master')

@section('content')
    <simple-navbar :show="true"></simple-navbar>
@stop

@section('script')
    <script src="{{ mix('js/app.js') }}"></script>

@stop

@section('styles')
    <style>
        .app-main {
            padding-top: 100px !important;
            margin-left: 0px !important;
            transform: translate3d(0, 0, 0);

        }

        .app-content {
            padding: 20px;
        }
    </style>
@stop
