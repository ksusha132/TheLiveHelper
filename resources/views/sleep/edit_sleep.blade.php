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
        <form role="form" method="post" action="{{ url('sleep/edit_sleep/' . $sleep->id_sleep ) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="time_start_sleep">Time start sleep </label>
                <input type="time" class="form-control" id="time_start_sleep" placeholder="Time start sleep" name='time_start_sleep' value="{{{$sleep->time_start_sleep}}}"/>
            </div>

            <div class="form-group">
                <label for="time_end_sleep">Time end sleep</label>
                <input type="time" class="form-control" id="time_end_sleep" placeholder="Time end sleep" name="time_end_sleep" value="{{{$sleep->time_end_sleep}}}" />
            </div>

            <div class="form-group">
                <label for="pleasure">Plesure</label>
                <input type="text" class="form-control" id="pleasure" placeholder="pleasure" name="pleasure" value="{{{$sleep->pleasure}}}">
            </div>

            <div class="form-group">
                <label for="sleep">Type of sleep</label>
                {!! Form::select('id_type_of_sleep', $type_of_sleep, $sleep->id_type_of_sleep, ['class' => 'form-control']) !!}
            </div>

            <button type="submit" class="btn btn-default">Send</button>

            <div>
                <a href="{{ url('user/day/'.$date )}}"
                   class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>



@endsection