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
        <form role="form" method="post" action="{{ url('food/edit_meal/'. $meal->id_meal) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" class="form-control" id="time" placeholder="Time" name='time' value="{{{$meal->time}}}">
            </div>

            <button type="submit" class="btn btn-default">Send</button>
            <div>
                <a href="{{ url('user/day/'.$date )}}"
                   class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>



@endsection