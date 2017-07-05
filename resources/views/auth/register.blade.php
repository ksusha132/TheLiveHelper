@extends('layouts.app')

@section('css')
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
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
        <form role="form" method="post" action="{{ url('auth/register') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name='email'>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Повторите пароль</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Повторите пароль"
                       name="password_confirmation">
            </div>

            <div class="form-group">
                {!! captcha_image_html('RegisterCaptcha') !!}
                <input type="text" id="CaptchaCode" name="CaptchaCode">
            </div>

            <button type="submit" class="btn btn-default">Отправить</button>
        </form>
    </div>



@endsection