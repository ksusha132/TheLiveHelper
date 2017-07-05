@extends('layouts.app')
@section('title', 'Requests')
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
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->name}}</td>
                    <td><a href="{{ url('user/show/'.$request->id)}}"> <img class="img-responsive img-rounded"
                                                                            src="{{ url('images/users/'.$request->photo) }}"
                                                                            alt="{{$request->name}}"></a></td>
                    <td><a href="{{ url('user/accept_to_friends', $request->id) }}" class="btn btn-primary">Accept</a>
                    </td>
                    <td><a href="{{ url('user/deny_request', $request->id) }}" class="btn btn-warning">Deny</a>
                </tr>
            @endforeach
        </table>
    </div>




@endsection

