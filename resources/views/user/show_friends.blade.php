@extends('layouts.app')
@section('title', 'Friends')
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
        <table class="table">
            @foreach($friends as $friend)
                <tr>
                    <td>{{ $friend->name}}</td>
                    <td><a href="{{ url('user/show/'.$friend->id)}}"><img class="img-responsive img-rounded"
                                                                          src="{{ url('images/users/'.$friend->photo) }}"
                                                                          alt="{{$friend->name}}"></a></td>
                    <td><a href="{{ url('user/remove_from_friends', $friend->id)}}" class="btn btn-primary">Remove from
                            friends</a></td>
                </tr>
            @endforeach
        </table>
    </div>




@endsection

