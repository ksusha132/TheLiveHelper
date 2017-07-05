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
        <form role="form" method="post" action="{{ url('train/edit_set/'. $set->id_set)}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="set_num">Set num</label>
                <input type="text" class="form-control" id="set_num" placeholder="Set num" name="set_num" value="{{$set->set_num}}">
            </div>

            <div class="form-group">
                <label for="reps">Reps</label>
                <input type="text" class="form-control" id="reps" placeholder="Reps" name="reps" value="{{$set->reps}}">
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" class="form-control" id="weight" placeholder="weight" name="weight" value="{{$set->weight}}">
            </div>

            <div class="form-group">
                <label for="id_ex">Exercise</label>
                {!! Form::select('id_ex', $exercises, $set->id_ex, ['class' => 'form-control']) !!}
            </div>


            <button type="submit" class="btn btn-default">Send</button>
            <div>
                <a href="{{ url('train/show_sets/'.$train->id_train )}}"
                   class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>



@endsection