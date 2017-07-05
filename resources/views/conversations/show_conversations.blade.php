@extends('layouts.app')
@section('title', 'Conversations')
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
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>My conversations</h2>
                <table class="table">
                    @foreach($conversations as $conversation)
                        <tr>
                            <td class="text-center" width="18%">
                                <img class="img-responsive" src="{{ url('images/users/'.$conversation->target_photo) }}"
                                     alt="{{$conversation->target_name}}" class="img-circle">
                                <a href="{{ url('user/show/'.$conversation->target_id) }}">{{$conversation->target_name}}</a>
                            </td>
                            <td style="vertical-align:middle;">
                                <div class="col-md-2">
                                    <img class="img-responsive img-rounded"
                                         src="{{ url('images/users/'.$conversation->author->photo) }}"
                                         alt="{{$conversation->author->name}}">
                                    <p class="text-center">{{$conversation->author->name}}</p>
                                </div>
                                <div class="col-md-10">
                                    <a href="{{ url('conversations/'.$conversation->id_conversation) }}">{{substr($conversation->last_message->message,0,30)}}</a>
                                    @if(strlen($conversation->last_message->message) > 30)
                                        ...
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </table>
                {{$conversations->links()}}
            </div>
        </div>



@endsection