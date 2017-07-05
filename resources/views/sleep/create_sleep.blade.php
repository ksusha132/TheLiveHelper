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
        <h4>Attention! You fill sleep data for last night!</h4>
        <form role="form" method="post" action="{{ url('sleep/create_sleep/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="time_start_sleep">Time start sleep </label>
                <input type="time" class="form-control" id="time_start_sleep" placeholder="Time start sleep" name='time_start_sleep' value="{!! old('time_start_sleep') !!}"/>
            </div>

            <div class="form-group">
                <label for="time_end_sleep">Time end sleep</label>
                <input type="time" class="form-control" id="time_end_sleep" placeholder="Time end sleep" name="time_end_sleep" value="{!! old('time_end_sleep') !!}" />
            </div>

            <div class="form-group">
                <label for="pleasure">Plesure</label>
                <input type="text" class="form-control" id="pleasure" placeholder="pleasure" name="pleasure" value="{!! old('pleasure') !!}" />
            </div>

            <div class="form-group">
                <label for="id_type_of_sleep">Type of sleep</label>
               <select name="id_type_of_sleep" class="form-control">
                @foreach($type_of_sleep as $type)
                       <option value="{{{ $type->id_type_of_sleep }}}">{{{ $type->sleep_name }}}</option>
                @endforeach
               </select>
            </div>

            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>



@endsection