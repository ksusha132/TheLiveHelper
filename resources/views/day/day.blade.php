@extends('layouts.app')
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


        <table class="table table-striped">
            <tr>
                <th>Time start</th>
                <th>Time end</th>
                <th>Averagepulse</th>
                <th>Date</th>
                <th>Type train</th>
                <th>Trainer</th>
                <th>Delete</th>
                <th>Update</th>
                <th>Exercises</th>
            </tr>
            @foreach($trains as $train)
                <tr>
                    <td>{{ $train->timestart }}</td>
                    <td>{{ $train->timeend }}</td>
                    <td>{{ $train->average_pulse }}</td>
                    <td>{{ $train->date }}</td>
                    <td>{{ $train->type_trains->type_name }}</td>
                    <td>{{ !empty($train->trains_client->first()->name) ? $train->trains_client->first()->name : '' }}</td>
                    <td><a href="{{ url('train/delete_train', $train->id_train) }}" class="btn btn-danger">Delete</a>
                    </td>
                    <td><a href="{{ url('train/edit_train', $train->id_train) }}" class="btn btn-warning">Update</a>
                    </td>
                    <td><a href="{{ url('train/show_sets', $train->id_train) }}" class="btn btn-success">Sets</a></td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('train/create_train/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}"
           class="btn btn-primary">Create new train</a>

        <h5>This graph shows your trains for current month</h5>
        <div id="chart_div1"></div>

        <table class="table table-striped">
            <tr>
                <th>Time</th>
                <th>Delete</th>
                <th>Update</th>
                <th>Eaten</th>
            </tr>
            @foreach($meals as $meal)
                <tr>
                    <td>{{{ $meal->time }}}</td>
                    <td><a href="{{ url('food/delete_meal', $meal->id_meal) }}" class="btn btn-danger">Delete</a></td>
                    <td><a href="{{ url('food/edit_meal', $meal->id_meal) }}" class="btn btn-warning">Update</a></td>
                    <td><a href="{{ url('food/show_eaten', $meal->id_meal) }}" class="btn btn-success">Eaten</a></td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('food/create_meal/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}"
           class="btn btn-primary">Create new meal</a>
        <h5>This graph shows your eaten food for current month</h5>
        <div id="chart_div2"></div>

        <table class="table table-striped">
            <tr>
                <th>Time start sleep</th>
                <th>Time end sleep</th>
                <th>Pleasure</th>
                <th>Date</th>
                <th>Type sleep</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            @foreach($sleep as $son)
                <tr>
                    <td>{{{ $son->time_start_sleep }}}</td>
                    <td>{{{ $son->time_end_sleep }}}</td>
                    <td>{{{ $son->pleasure }}}</td>
                    <td>{{{ $son->date }}}</td>
                    <td>{{{ $son->type_of_sleep->sleep_name }}}</td>
                    <td><a href="{{ url('sleep/delete_sleep', $son->id_sleep) }}" class="btn btn-danger">Delete</a></td>
                    <td><a href="{{ url('sleep/edit_sleep', $son->id_sleep) }}" class="btn btn-warning">Update</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('sleep/create_sleep/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}"
           class="btn btn-primary">Create new sleep</a>

        <h5>This grap shows your sleep for current month</h5>
        <div id="chart_div3"></div>

        <table class="table table-striped">
            <tr>
                <th>Weight</th>
                <th>Date</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            @foreach($weight as $w)
                <tr>
                    <td>{{ $w->weight }}</td>
                    <td>{{ $w->date }}</td>
                    <td><a href="{{ url('weight/delete_weight', $w->id_weight) }}" class="btn btn-danger">Delete</a>
                    </td>
                    <td><a href="{{ url('weight/edit_weight', $w->id_weight) }}" class="btn btn-warning">Update</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('weight/create_weight/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}"
           class="btn btn-primary">Create weight</a>
        <h5>This grap shows your weight's dynamic for month</h5>
        <div id="chart_div4"></div>

        @if(Auth::user()->hasRole('Trainer'))
            <table class="table table-striped">
                <tr>
                    <th>Time start</th>
                    <th>Time end</th>
                    <th>Date</th>
                    <th>Type of train</th>
                    <th>Client</th>
                    <th>Delete</th>
                    <th>Update</th>
                    <th>Sets</th>
                </tr>
                @foreach($clients_trains as $clients_train)
                    <tr>
                        <td>{{{ $clients_train->timestart }}}</td>
                        <td>{{{ $clients_train->timeend }}}</td>
                        <td>{{{ $clients_train->date }}}</td>
                        <td>{{{ $clients_train->type_trains->type_name }}}</td>
                        <td>{{{ $clients_train->user->name }}}</td>
                        <td><a href="{{ url('train/delete_train', $clients_train->id_train) }}"
                               class="btn btn-danger">Delete</a>
                        </td>
                        <td><a href="{{ url('train/edit_train', $clients_train->id_train) }}" class="btn btn-warning">Update</a>
                        </td>
                        <td><a href="{{ url('train/show_sets', $clients_train->id_train) }}" class="btn btn-success">Sets</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <a href="{{ url('train/create_client_train/'.Request::segment(3). '/' . Request::segment(4) .'/'.Request::segment(5)) }}"
               class="btn btn-primary">Create new client train</a>
        @endif

        <script type="text/javascript">

            // Load the Visualization API and the piechart package.
            google.charts.load('current', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);


            function drawChart() {
                var jsonData1 = $.ajax({
                    url: "/train/draw_graph/{{$date}}",
                    dataType: "json",
                    async: false
                }).responseText;
                var jsonData2 = $.ajax({
                    url: "/food/show_graph/{{$date}}",
                    dataType: "json",
                    async: false
                }).responseText;
                var jsonData3 = $.ajax({
                    url: "/sleep/show_graph/{{$date}}",
                    dataType: "json",
                    async: false
                }).responseText;
                var jsonData4 = $.ajax({
                    url: "/weight/show_graph/{{$date}}",
                    dataType: "json",
                    async: false
                }).responseText;
                // Create our data table out of JSON data loaded from server.
                var data1 = new google.visualization.DataTable(jsonData1);

                // Instantiate and draw our chart, passing in some options.
                var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
                chart1.draw(data1, {width: 500, height: 340});

                var data2 = new google.visualization.DataTable(jsonData2);

                // Instantiate and draw our chart, passing in some options.
                var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
                chart2.draw(data2, {width: 500, height: 340});

                var data3 = new google.visualization.DataTable(jsonData3);

                // Instantiate and draw our chart, passing in some options.
                var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));
                chart3.draw(data3, {width: 500, height: 340});

                var data4 = new google.visualization.DataTable(jsonData4);

                // Instantiate and draw our chart, passing in some options.
                var chart4 = new google.visualization.AreaChart(document.getElementById('chart_div4'));
                chart4.draw(data4, {width: 500, height: 340});
            }

        </script>
    </div>



@endsection