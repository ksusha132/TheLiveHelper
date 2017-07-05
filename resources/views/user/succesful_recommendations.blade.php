@extends('layouts.app')
@section('title', 'Recomendations')
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
        <table class="table">
            @foreach($succesful_recommendations as $succesful_recommendation)
                <tr>
                    <td>{{$succesful_recommendation->date_start_programm}}</td>
                    <td>{{$succesful_recommendation->date_end_programm}}</td>
                    <td> @if (!empty($succesful_recommendation->day))

                            @foreach($succesful_recommendation->day as $key=>$item)
                                day {{ $key + 1 }}<br>
                                @foreach($item as $type_train)
                                    @foreach($type_train->exercises as $exercise)
                                        {{$exercise->name}}<br>
                                    @endforeach
                                @endforeach
                                <br><br><br>
                            @endforeach
                        @endif</td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection