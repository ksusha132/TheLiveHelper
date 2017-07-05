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
        @if (!empty($recommendation))
            @if($date_end_programm == date('Y-m-d'))
                <a href="{{ url('user/recommendations/approve/' . $recommend->id_recommendation) }}" type="submit"
                   class="btn btn-success">Was recommendation useful?</a>
            @endif
            <p>{{$recommendation}}</p>
        @endif
        <a href="{{ url('user/succesful_recommendations') }}" class="btn btn-success">Succesful
            recomndations</a>


        <div class="panel-group">
            <h3>Your current data</h3>
            <p>{{$goal}}</p>
            <p>{{$life_style}}</p>
            <p>{{$count_days}}</p>
            <p>{{$date_start_programm}}</p>
            <p>{{$date_end_programm}}</p>
        </div>
        <h3>Your recommendations</h3>
        @if (!empty($day))

            @foreach($day as $key=>$item)
                day {{ $key + 1 }}<br>
                @foreach($item as $type_train)
                    @foreach($type_train->exercises as $exercise)
                        {{$exercise->name}}<br>
                    @endforeach
                @endforeach
                <br><br><br>
            @endforeach
        @endif


        <form role="form" method="post" action="{{ url('user/recommendations') }}">
            {!! csrf_field() !!}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Choose your goal</label>
                    <select name="id_question" class="form-control">
                        <option value="1">To lose overweight</option>
                        <option value="2">To lose overweight and gain muscles</option>
                        <option value="3">To gain muscles</option>
                        <option value="4">To save my form</option>
                    </select>

                    <label for="">How many times are you going to go to gym?</label>
                    <select name="count_days" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>

                    <label for="life_style">What id your life activity?</label>
                    <select name="life_style" class="form-control">
                        <option value="Sedentary">Sedentary</option>
                        <option value="Small activity">Small activity</option>
                        <option value="Moderate activity">Moderate activity</option>
                        <option value="High activity">High activity</option>
                    </select>

                    <div class="form-group">
                        <label for="date_start_programm">Date start programm</label>
                        <input type="date" class="form-control" id="date_start_programm"
                               placeholder="date_start_programm" name="date_start_programm"/>
                    </div>

                    <div class="form-group">
                        <label for="date_end_programm">Date end programm</label>
                        <input type="date" class="form-control" id="date_end_programm" placeholder="date_end_programm"
                               name="date_end_programm"/>
                    </div>

                </div>


                <button type="submit" class="btn btn-success">Send</button>
            </div>
        </form>
    </div>
@endsection