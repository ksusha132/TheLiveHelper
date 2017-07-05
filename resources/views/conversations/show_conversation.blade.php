@extends('layouts.app')
@section('title', 'Conversations')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="col-md-2 participants">
                <h5>Participants of the dialog</h5>
                @foreach($participants as $participant)
                    <span>{{$participant->name}}</span>
                    <a data-id_user="{{$participant->id}}" href="{{ url('user/show/'.$participant->id)}}"> <img
                                class="img-responsive img-rounded"
                                src="{{ url('images/users/'.$participant->photo) }}"
                                alt="{{$participant->name}}"></a>

                @endforeach

            </div>
            <div class="col-md-8">
                <table class="table messages">
                    @foreach($messages as $message)
                        <tr class="message_row {{ $message->pivot->status == 0 ? 'info' : ''}}"
                            data-id_message="{{$message->id_message}}"
                            data-status="{{$message->pivot->status}}">
                            <td style="vertical-align:middle;">
                                <div class="col-md-2">
                                    <a href="{{ url('user/show/'.$message->id_user)}}"> <img
                                                class="img-responsive img-rounded"
                                                src="{{ url('images/users/'.$participants[$message->id_user]['photo']) }}"
                                                alt="{{$participants[$message->id_user]['name']}}"></a>
                                </div>
                                <div class="col-md-10">
                                    {{$message->message}}
                                    <a class="btn btn-danger btn-xs delete_message"
                                       style="position: absolute; right: 30px; display: none;"><span
                                                class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="col-md-12">
                    <form role="form" method="post" action="{{ url('conversations/send_message/')}}"> <!ай ди
                        берет из браузера--!>
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_conversation" value="{{ Request::segment(2)}}">
                        <div class="col-md-12">
                            <textarea name="message" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-4">
                            <button id="send" type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $('.messages').on('click', "[class*='delete_message']", function () {
                if (confirm('Delete message ?')) {
                    var tr = $(this).closest('.message_row');
                    $.ajax({
                        url: 'delete_message',
                        type: 'post',
                        data: {
                            id_message: tr.data('id_message')
                        },
                        dataType: 'json',
                        success: function (json) {
                            if (json.status == 'OK') {
                                tr.fadeOut(function () {
                                    $(this).remove();
                                });
                            }
                        },
                        error: function (xhr, status) {
                            alert('Произошла ошибка');
                        }
                    });
                }
            });
            $('[class~="messages"] tr').on('mouseenter', function () {
                $(this).find('[class~="delete_message"]').stop().fadeIn();
            });
            $('[class~="messages"] tr').on('mouseleave', function () {
                $(this).find('[class~="delete_message"]').stop().fadeOut();
            });

            $('[class~="messages"] tr').on('mouseenter', function (e) {
                var tr = $(this);
                if ($(this).data('status') == 0) {
                    $.ajax({
                        url: 'read_message',
                        type: 'post',
                        data: {
                            id_message: tr.data('id_message')
                        },
                        dataType: 'json',
                        success: function (json) {
                            if (json.status == 1) {
                                tr.removeClass('info');
                            }
                        },
                    });
                }
            });

            $('#send').on('click', function (e) {
                e.preventDefault();
                var tr = $(this).closest('.message_row');
                $.ajax({
                    url: 'send_message',
                    type: 'post',
                    data: {
                        message: $('[name="message"]').val(),
                        id_conversation: $('[name="id_conversation"]').val()
                    },
                    dataType: 'json',
                    complete: function () {
                        $('[name="message"]').val('');

                    },
                    error: function (xhr, status) {
                        // alert('Произошла ошибка');
                    }
                });
            });

            setInterval(function () {
                $.ajax({
                    url: 'get_messages',
                    type: 'post',
                    data: {
                        id_message: $('[class~="messages"] tr:last').data('id_message'),
                        id_conversation: $('[name="id_conversation"]').val()
                    },
                    dataType: 'json',
                    success: function (json) {
                        if (!$.isEmptyObject(json.messages)) {
                            $(json.messages).each(function (index, element) {
                                var stat = '';
                                if (json.messages[index].pivot.status == 0){
                                    stat = ' info';
                                }
                                var message_html = '';
                                message_html += '<tr class="message_row'+ stat +'" data-id_message="' + json.messages[index].id_message + '" data-status="' + json.messages[index].pivot.status + '">';
                                message_html += '<td style="vertical-align:middle;">';
                                message_html += '<div class="col-md-2">';
                                message_html += '<a href="/user/show/' + json.messages[index].id_user + '">';
                                message_html += '<img class="img-responsive img-rounded" src="' + $('[class~="participants"] a[data-id_user="' + json.messages[index].id_user + '"] img').attr('src') + '"></a> </div>';
                                message_html += '<div class="col-md-10">';
                                message_html += json.messages[index].message;
                                message_html += '<a class="btn btn-danger btn-xs delete_message" style="position: absolute; right: 30px; display: none;">';
                                message_html += '<span class="glyphicon glyphicon-remove"></span></a></div></td></tr>';
                                var message = $(message_html);
                                message.appendTo($('[class~="messages"]'));
                            });
                        }
                    },
                    error: function (xhr, status) {
                        //alert('Произошла ошибка');
                    }
                });
            }, 1000)


        });
    </script>
@endsection