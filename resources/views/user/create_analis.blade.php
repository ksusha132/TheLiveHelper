@extends('layouts.app')
@section('title', 'Analises')
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
    <form role="form" method="post" action="{{ url('user/create_analis') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="analis">Analis</label>
            <select name="id_analis" class="form-control">
                @foreach($Analis as $an)
                    <option value="{{ $an->id_analis }}">{{ $an->name_analis }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="Analis_results">User's data</label>
            <input type="text" class="form-control" id="input_user_analis" placeholder="User's data" name="input_user_analis" />
        </div>

        <button type="submit" class="btn btn-default">Send</button>
    </form>
    <div>
        <a href="{{ url('user/show_analis' )}}"
           class="btn btn-primary">Back</a>
    </div>
</div>



@endsection