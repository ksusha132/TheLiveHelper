@extends('layouts.app')
@section('title', 'Analises')
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
        <form role="form" method="post" action="{{ url('user/create_analis') }}">
            {!! csrf_field() !!}

            <div class="form-group">
                <table class="table table-bordered">
                    <tr>
                        <th>Name of user's analis</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>User's analis</th>
                        <th>Norma analis min</th>
                        <th>Norma analis max</th>
                        <th>Delete</th>
                        <th>Update</th>
                    </tr>
                    <tr>
                        @foreach($analis_results as $analis_result)

                            <td>{{$analis_result->analis->name_analis}}</td>
                            <td>{{$analis_result->created_at}}</td>
                            <td>{{$analis_result->updated_at}}</td>
                            @if (($analis_result->input_user_analis < $analis_result->analis['norma_analis_'. Auth::user()->sex .'_min']) || ($analis_result->input_user_analis > $analis_result->analis['norma_analis_'. Auth::user()->sex .'_max']))
                                <td class="alert-danger">{{$analis_result->input_user_analis}}</td>
                                <td>{{$analis_result->analis['norma_analis_'. Auth::user()->sex .'_min']}}</td>
                                <td> {{$analis_result->analis['norma_analis_'. Auth::user()->sex .'_max']}}</td>

                                <td><a href="{{ url('user/delete_analis', $analis_result->id_results) }}"
                                       class="btn btn-danger">Delete</a>
                                </td>
                                <td><a href="{{ url('user/edit_analis', $analis_result->id_results) }}"
                                       class="btn btn-warning">Update</a>
                            @else
                                <td class="alert-success">{{$analis_result->input_user_analis}}</td>
                                <td>{{$analis_result->analis['norma_analis_'. Auth::user()->sex .'_min']}}</td>
                                <td> {{$analis_result->analis['norma_analis_'. Auth::user()->sex .'_max']}}</td>

                                <td><a href="{{ url('user/delete_analis', $analis_result->id_results) }}"
                                       class="btn btn-danger">Delete</a>
                                </td>
                                <td><a href="{{ url('user/edit_analis', $analis_result->id_results) }}"
                                       class="btn btn-warning">Update</a>
                            @endif
                    </tr>
                    @endforeach
                </table>


                <a href="{{ url('user/create_analis')}}"
                   class="btn btn-primary">Create new analis</a>


            </div>

        </form>
        <form role="form" method="post" action="{{ url('user/show_analis') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="data_from">From</label>
                <input type="date" class="form-control" id="date_from" placeholder="Y-m-d from" name='date_from'/>
            </div>

            <div class="form-group">
                <label for="data_to">To</label>
                <input type="date" class="form-control" id="date_to" placeholder="Y-m-d to" name='date_to'/>
            </div>
            <button type="submit" class="btn btn-default">Send</button>
        </form>

        @foreach($analises as $analis)
            <div id="chart_div{{$analis->id_analis}}"></div>

        @endforeach

        <script type="text/javascript">

            // Load the Visualization API and the piechart package.
            google.charts.load('current', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);


            function drawChart() {
                        @foreach($analises as $analis)
                var jsonData{{$analis->id_analis}} = $.ajax({
                            url: "/analis/draw_graph/{{$analis->id_analis}}/{{!empty($date_from) ? $date_from : ''}}/{{!empty($date_to) ? $date_to : ''}}",
                            dataType: "json",
                            async: false
                        }).responseText;

                // Create our data table out of JSON data loaded from server.
                var data{{$analis->id_analis}} = new google.visualization.DataTable(jsonData{{$analis->id_analis}});

                // Instantiate and draw our chart, passing in some options.
                var chart{{$analis->id_analis}} = new google.visualization.AreaChart(document.getElementById('chart_div{{$analis->id_analis}}'));
                chart{{$analis->id_analis}}.draw(data{{$analis->id_analis}}, {width: 500, height: 340});
                @endforeach
            }

        </script>

    </div>

@endsection