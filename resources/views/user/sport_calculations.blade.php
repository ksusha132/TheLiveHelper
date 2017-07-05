@extends('layouts.app')
@section('title', 'Sport Calculations')
@section('javascript')
    <script src="/assets/arkhas/calendar/calendar.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('css')
    <link rel="stylesheet" href="/assets/arkhas/calendar/calendar.css">
@endsection
@section('content')
    <div class="container">
        @if ($errors->has())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-danger" role="alert">
                        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li> {{{ $error }}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if(Auth::user())
            <div>
                <p>Body mass index:</p>
                {{$IMT}}
            </div>
            <div>
                <p> Calculate main exchange:</p>
                {{$ROO}}
            </div>
            <div>
                <p>Harris Benedict formula:</p>
                {{$Harris_Benedict}}
            </div>

            <p> Calculate necessary consume cal per day:</p>
            <table class="table">
                <tr>
                    <th>Life style</th>
                    <th>Description</th>
                    <th>Real expense</th>
                    <th>Gain mass</th>
                    <th>Burn fat</th>
                    <th>Constant weight</th>
                </tr>
                @foreach($RFC as $title=>$type)
                    <tr>
                        <td>{{$title}}</td>
                        <td>{{$type['description']}}</td>
                        <td>{{$type['value']}}</td>
                        <td>{{$type['gain']}}</td>
                        <td>{{$type['fat_burn']}}</td>
                        <td>{{$type['constant_weight']}}</td>
                    </tr>
                @endforeach
            </table>
    </div>
    @endif




@endsection