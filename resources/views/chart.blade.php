@extends('laravel-usp-theme::master')

@section('styles')
@parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
@endsection

@section('content')
        @yield('content_top')
        <div id="app">
            {!! $chart->container() !!}
        </div>

        <script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

        {!! $chart->script() !!}


        @yield('content_footer')
        <script scr="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js">
@endsection
