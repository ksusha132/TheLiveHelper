@extends('layouts.app')
@section('title', 'Edit profile')
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

        <form role="form" method="post" action="{{ url('user/edit') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="panel-body">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" id="photo" name="photo">
                    </div>
                    <img class="img-thumbnail" src="{{ url('images/users/'.$user->photo) }}">
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="name" name='name'
                               value="{{$user->name}}">
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" id="age" placeholder="age" name='age'
                               value="{{$user->age}}">
                    </div>

                    @if(Auth::user()->hasAnyRole(['Trainer','Admin']))
                        <div class="form-group">
                            <label for="education">Education</label>
                            <input type="text" class="form-control" id="education" placeholder="education"
                                   name="education"
                                   value="{{$user->education}}">
                        </div>

                        <div class="form-group">
                            <label for="achivements">Achivements</label>
                            <input type="text" class="form-control" id="achivements" placeholder="achivements"
                                   name="achivements" value="{{$user->achivements}}">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="current_goal">Current goal</label>
                        <input type="text" class="form-control" id="current_goal" placeholder="Current goal"
                               name="current_goal" value="{{$user->current_goal}}">
                    </div>

                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" class="form-control" id="Height" placeholder="Height"
                               name="height" value="{{$user->height}}">
                    </div>

                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" class="form-control" id="weight" placeholder="Weight"
                               name="weight" value="{{$user->weight}}">
                    </div>

                    <div class="form-group">
                        <label for="active_nuclear_weight">Desired weight</label>
                        <input type="text" class="form-control" id="desired_weight"
                               placeholder="desired_weight"
                               name="desired_weight" value="{{$user->desired_weight}}">
                    </div>

                    <div class="form-group">
                        <label for="muscle_weight">Muscle weight %</label>
                        <input type="text" class="form-control" id="muscle_weight" placeholder="muscle_weight"
                               name="muscle_weight" value="{{$user->muscle_weight}}">
                    </div>

                    <div class="form-group">
                        <label for="active_nuclear_weight">Active nuclear weight %</label>
                        <input type="text" class="form-control" id="active_nuclear_weight"
                               placeholder="active_nuclear_weight"
                               name="active_nuclear_weight" value="{{$user->active_nuclear_weight}}">
                    </div>

                    <div class="form-group">
                        <label for="sex">Sex</label>
                        {!! Form::select('sex', array('female' => 'Female','male' => 'Male'), $user->sex , ['class' => 'form-control']) !!}
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Send</button>
                <a href="{{ url('user/delete') }}" class="btn btn-danger">Delete my account</a>
            </div>
        </form>
        <form role="form" method="post" action="{{ url('user/upload_photo') }}" enctype="multipart/form-data">
            <div class="form-group">
                {!! csrf_field() !!}
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-success">Add photo to gallery</button>
        </form>
        <div class="panel-body">
            @foreach($photos as $photo)
                <div class="col-md-4">
                    <img class="img-rounded col-xs-4" src="{{ url('images/users/gallery/'.$photo->name) }}">
                    <a href="{{url('user/delete_photo/' . $photo->id_photo)}}">Delete</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection