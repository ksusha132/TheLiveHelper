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
        <form role="form" method="post" action="{{ url('food/edit_eaten/'. $eaten->id_eaten) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="calories">Calories</label>
                <input type="text" class="form-control" id="calories" placeholder="Calories" name='calories' value="{{{$eaten->calories}}}"/>
            </div>

            <div class="form-group">
                <label for="gramm">Gramm</label>
                <input type="text" class="form-control" id="gramm" placeholder="gramm" name="gramm" value="{{{$eaten->gramm}}}" />
            </div>


            <div class="form-group">
                <label for="food">Food</label>
                {!! Form::select('id_food', $food, $eaten->id_food, ['class' => 'form-control']) !!}
            </div>

            <button type="submit" class="btn btn-default">Send</button>

            <div>
                <a href="{{ url('food/show_eaten/'. $eaten->id_meal )}}"
                   class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>



@endsection