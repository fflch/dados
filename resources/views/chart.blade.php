@extends('laravel-usp-theme::master')

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
        @yield('top')
        @yield('content_footer')
@endsection
