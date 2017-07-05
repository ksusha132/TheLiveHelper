@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">News from admin</div>

                    <div class="panel-body">
                        Hello! You're logged in. Here you can see the latest news from admin. It can be changes of our
                        system the main news from medicine.
                        Enjoy!
                    </div>

                    <div class="panel-body">
                        We've made requests and messages!
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Your agenda!</div>

                    <div class="panel-body">
                        Here you can see your apointments. For example: today you have to go to train at 15:30. You have
                        to train your legs.
                        Also, you can see your meal and sleep.
                        you are able to add this information ...()
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <th>Time start</th>
                            <th>Time end</th>
                            <th>Date</th>
                            <th>Type train</th>
                        </tr>
                        @foreach($trains as $train)
                            <tr>
                                <td>{{{ $train->timestart }}}</td>
                                <td>{{{ $train->timeend }}}</td>
                                <td>{{{ $train->date }}}</td>
                                <td>{{{ $train->type_trains->type_name }}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
