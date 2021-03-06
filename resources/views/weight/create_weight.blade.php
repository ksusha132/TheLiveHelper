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
        <form role="form" method="post" action="{{ url('weight/create_weight/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="weight" class="form-control" id="weight" placeholder="Weight" name='weight' value="{!! old('weight') !!}"/>
            </div>


            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>



@endsection