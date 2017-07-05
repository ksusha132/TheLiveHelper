@extends('layouts.app')

@section('content')
    <div class="container">
        {{--Ошибки--}}
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
        <form role="form" method="post" action="{{ url('train/create_client_train/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="timestart">Time start</label>
                <input type="time" class="form-control" id="timestart" placeholder="Time start" name='timestart' value="{!! old('timestart') !!}"/>
            </div>

            <div class="form-group">
                <label for="timeend">Time end</label>
                <input type="time" class="form-control" id="timeend" placeholder="Time end" name="timeend" value="{!! old('timeend') !!}" />
            </div>

            <div class="form-group">
                <label for="typetrain">Type train</label>
                <select name="id_type" class="form-control">
                    @foreach($type_trains as $type)
                        <option value="{{ $type->id_type }}">{{ $type->type_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="friend">Client</label>
                <select name="friend" class="form-control">
                    @foreach($friends as $friend)
                        <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>



@endsection