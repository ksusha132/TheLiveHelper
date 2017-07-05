@extends('layouts.app')
@section('title', 'Vitamins')
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
        <table class="table table-bordered">
            <thead>
            <td>Name vitamin</td>
            <td>Consumed vitamin</td>
            </thead>
            <tbody>
            @foreach($vitamins as $vitamin)
                <tr class="{{$vitamin->status}}">
                    <td>{{$vitamin->name}}</td>
                    <td>{{$vitamin->consumed}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div>
            <a href="{{ url('user/show/'.Auth::user()->id )}}"
               class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection