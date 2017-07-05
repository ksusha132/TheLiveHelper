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
        <form role="form" method="post" action="{{ url('food/create_eaten/'.Request::segment(3)) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="calories">Calories</label>
                <input type="calories" class="form-control" id="calories" placeholder="calories" name='calories' value="{!! old('calories') !!}"/>
            </div>

            <div class="form-group">
                <label for="gramm">Gramm</label>
                <input type="gramm" class="form-control" id="gramm" placeholder="gramm" name="gramm" value="{!! old('gramm') !!}"/>
            </div>

            <div class="form-group">
                <label for="id_food">Food</label>
               <select name="id_food" class="form-control">
                @foreach($food as $eda)
                       <option value="{{{ $eda->id_food }}}">{{{ $eda->title }}}</option>
                @endforeach
               </select>
            </div>

            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>



@endsection