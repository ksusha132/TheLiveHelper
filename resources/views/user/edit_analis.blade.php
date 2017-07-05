@extends('layouts.app')
@section('title', 'Edit analises')
@section('content')
    <div class="container">
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
        <form role="form" method="post" action="{{ url('user/edit_analis/' . $analis_result->id_results) }}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}


            <div class="col-lg-6">
                <div class="form-group">
                    <label for="analis">Name analis</label>

                    {!! Form::select('id_analis', $analis, $analis_result->id_analis, ['class' => 'form-control']) !!}

                </div>

                <div class="form-group">
                    <label for="input_user_analis">User's analis</label>
                    <input type="text" class="form-control" id="input_user_analis" placeholder="input_user_analis" name='input_user_analis'
                           value="{{$analis_result->input_user_analis}}">
                </div>


                <button type="submit" class="btn btn-success">Send</button>
                <a href="{{ url('user/show_analis/') }}" class="btn btn-danger">Back</a>

        </form>
    </div>
@endsection