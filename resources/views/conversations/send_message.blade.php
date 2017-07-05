@extends('layouts.app')
@section('title', ' Send message')
@section('javascript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

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
        <form role="form" method="post" action="{{ route('message.Send') }}">
            {!! csrf_field() !!}
                <div class=" form-group">
        <label for="message">Your message</label>
        <input type="hidden" name="sentto" value="1">
        <textarea name="message">

        </textarea>

    </div>

    <button type="submit" class="btn btn-default">Sent</button>
    </form>



@endsection