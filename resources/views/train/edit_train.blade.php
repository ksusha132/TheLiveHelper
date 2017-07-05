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
        <form role="form" method="post" action="{{ url('train/edit_train/'. $train->id_train) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="timestart">Time start</label>
                <input type="time" class="form-control" id="timestart" placeholder="Time start" name='timestart' value="{{{$train->timestart}}}">
            </div>

            <div class="form-group">
                <label for="timeend">Time end</label>
                <input type="time" class="form-control" id="timeend" placeholder="Time end" name="timeend" value="{{{$train->timeend}}}">
            </div>

            <div class="form-group">
                <label for="average_pulse">Average pulse</label>
                <input type="text" class="form-control" id="average_pulse" placeholder="Average pulse" name="average_pulse" value="{{{$train->average_pulse}}}">
            </div>

            <div class="form-group">
                <label for="typetrain">Type train</label>

                {!! Form::select('id_type', $type_trains, $train->id_type, ['class' => 'form-control']) !!}

            </div>

            <div class="form-group">
                <label for="date">Date</label>
                {{{$train->date}}}
            </div>



            <button type="submit" class="btn btn-default">Send</button>
            <div>
                <a href="{{ url('user/day/'.$date )}}"
                   class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>



@endsection