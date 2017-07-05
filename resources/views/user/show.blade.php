@extends('layouts.app')
@section('title', $user->name)
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('javascript')
    <script src="/assets/arkhas/calendar/calendar.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.magnific-popup.js"></script>
@endsection
@section('css')
    <link rel="stylesheet" href="/assets/arkhas/calendar/calendar.css">
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
@endsection
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
        @if (session('status'))
            <div class="alert alert-{{session('type')}}">
                {{ session('status') }}
            </div>
        @endif

        <div class="col-lg-4">
            <img class="img-thumbnail" src="{{ url('images/users/'.$user->photo) }}">
            <div class="popup-gallery">
                @foreach($photos as $photo)
                    <a href="{{ url('images/users/gallery/'.$photo->name) }}"><img class="img-rounded col-xs-4 "
                                                                                   src="{{ url('images/users/gallery/'.$photo->name) }}"></a>
                @endforeach
            </div>
        </div>
        @if( Auth::user())
            <div class="col-lg-2">
                @if(Auth::user()->id !== $user->id)
                    <button id="ModalBox1" type="button" class="btn btn-primary">Write a message</button>
                    @if($user->hasFriendRequestFrom(Auth::user()))
                        <p>The request has already been sent</p>
                    @elseif(!Auth::user()->isFriendWith($user) && !$user->hasBlocked(Auth::user()))
                        <a class="btn btn-primary" href="{{url('user/add_to_friends/' . $user->id)}}">Add to friends</a>
                    @else
                        <a class="btn btn-danger" href="{{url('user/remove_from_friends/' . $user->id)}}">Remove from
                            friends</a>
                    @endif


                    <div id="myModalBox1" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Заголовок модального окна -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        ×
                                    </button>
                                    <h4 class="modal-title">Type your message</h4>
                                </div>
                                <!-- Основное содержимое модального окна -->
                                <form role="form" method="post"
                                      action="{{ url('conversations/send_message/')}}">
                                    <div class="modal-body">
                                        {!! csrf_field() !!}
                                        <input id="id_user" name="id_user" type="hidden" value="{{$user->id}}">
                                        <textarea name="message" class="form-control" rows="2"></textarea>
                                    </div>
                                    <!-- Футер модального окна -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endif

                @if(Auth::user()->id == $user->id)
                    <a class="btn btn-danger btn-block" href="/user/sport_calculations">Sport calculation</a>
                @endif

                @if(Auth::user()->id == $user->id)
                    <a class="btn btn-danger btn-block" href="/calculations">Vitamin calculation</a>
                @endif
                @if(Auth::user()->id == $user->id)
                    <a class="btn btn-danger btn-block" href="/user/show_analis">Show analises</a>
                @endif
                @if(Auth::user()->id == $user->id)
                    <a class="btn btn-danger btn-block" href="/user/recommendations">Recommendations</a>
                @endif

                <button id="ModalBox3" type="button" class="btn btn-primary btn-block">Photos
                    of {{$user->name}} </button>
                <button id="ModalBox4" type="button" class="btn btn-primary btn-block">Friedns
                    of {{$user->name}} </button>
                @endif


            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <p>{{$user->name}}</p>
                </div>

                <div class="form-group">
                    <label for="sex">Gender</label>
                    <p>{{$user->sex}}</p>
                </div>

                <div class="form-group">
                    <label for="achivements">Achvements</label>
                    <p>{{$user->achivements}}</p>
                </div>

                @if(Auth::user()->hasAnyRole(['Admin', 'Trainer']) || $user->id == Auth::user()->id)

                    <div class="form-group">
                        <label for="name">Age</label>
                        <p>{{$user->age}}</p>
                    </div>

                    <div class="form-group">
                        <label for="height">Height</label>
                        <p>{{$user->height}}</p>
                    </div>

                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <p>{{$user->weight}}</p>
                    </div>

                    <div class="form-group">
                        <label for="desired_weight">Desired weight</label>
                        <p>{{$user->desired_weight}}</p>
                    </div>

                    <div class="form-group">
                        <label for="weight">Active nuclear weight</label>
                        <p>{{$user->active_nuclear_weight}}</p>
                    </div>

                    <div class="form-group">
                        <label for="weight">Muscle weight</label>
                        <p>{{$user->muscle_weight}}</p>
                    </div>

                    <div class="form-group">
                        <label for="current_goal">Current goal</label>
                        <p>{{$user->current_goal}}</p>
                    </div>
                @endif
            </div>
            <div class="col-lg-12">
                @if(Auth::user()->hasAnyRole(['Admin', 'Trainer']) || $user->id == Auth::user()->id)

                    {!! $calendar !!}
                @endif
            </div>

            <div class="pannel">
                @if(!empty($recommendation))
                    @if($recommendation->date_end_programm == $cur_data)
                        <p>Programm has finished! Check your results!</p>
                    @endif
                @endif
            </div>

            @if($user->hasRole('Trainer'))
                <table class="table table-striped reviews">
                    <tr>
                        <th>Name</th>
                        <th>Review</th>
                        @if(Auth::user()->hasRole('Admin'))
                            <th>Delete</th>
                        @endif
                    </tr>
                    @foreach($reviews as $review)
                        <tr class="review_row" data-id_review="{{$review->id_review}}">
                            <td>  {{$review->user->name}}</td>
                            <td> {{$review->review}} </td>
                            @if(Auth::user()->hasRole('Admin'))
                                <td><a class="btn btn-default delete_review">Delete</a></td>
                            @else({{redirect()->back()}})
                            @endif
                        </tr>
                    @endforeach
                </table>
                <form method="post" action="{{ url('user/create_review')}}" id="review">
                    {!! csrf_field() !!}
                    <input id="id_user" name="id_user" type="hidden" value="{{$user->id}}">
                    <textarea name="review" class="form-control" rows="2"></textarea>
                    <!-- Футер модального окна -->
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            @endif

    </div>

    <script>


        $(document).ready(function () {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                }
            });

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            //при нажатию на любую кнопку, имеющую класс .btn
            $("#ModalBox1").click(function () {
                //открыть модальное окно с id="myModal"
                $("#myModalBox1").modal('show');
            });

            $("#ModalBox2").click(function () {
                //открыть модальное окно с id="myModal"
                $("#myModalBox2").modal('show');
            });

            $('#review').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/user/create_review',
                    type: 'post',
                    data: {
                        review: $('[name="review"]').val(),
                        id_user: $('[name="id_user"]').val()
                    },
                    dataType: 'json',

                    success: function (json) {
                        if (!$.isEmptyObject(json.review)) {
                            var reviews_html = '';
                            reviews_html += '<tr  class="review_row" data-id_review="' + json.review.id_review + '">';
                            reviews_html += '<td>' + json.review.name + '</td>';
                            reviews_html += '<td>' + json.review.review + '</td>';
                            if (json.role == 'Admin') {
                                reviews_html += '<td>';
                                reviews_html += '<a class="btn btn-default delete_review">Delete';
                                reviews_html += '</a></td>';
                            } else {
                                reviews_html += '<td></td>';
                            }
                            reviews_html += '</tr>';
                            var review = $(reviews_html);
                            review.appendTo($('[class~="reviews"]'));
                        }
                    },

                    complete: function () {
                        $('[name="review"]').val('');

                    },
                    error: function (xhr, status) {
                        // alert('Произошла ошибка');
                    }
                });
            });

            $('[class~="reviews"]').on('click', "[class~='delete_review']", function (e) {
                e.preventDefault();
                if (confirm('Delete review ?')) {
                    var tr = $(this).closest('.review_row');
                    $.ajax({
                        url: '/user/delete_review',
                        type: 'post',
                        data: {
                            id_review: tr.data('id_review')
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

        });
    </script>



@endsection

