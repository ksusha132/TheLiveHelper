@extends('layouts.app')

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
                <th>Calories</th>
                <th>Gramm</th>
                <th>Food</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            @foreach($eaten as $eda)
                <tr>
                    <td>{{{ $eda->calories }}}</td>
                    <td>{{{ $eda->gramm }}}</td>
                    <td>{{{ $eda->food->title }}}</td>
                    <td><a href="{{ url('food/delete_eaten', $eda->id_eaten) }}" class="btn btn-danger">Delete</a></td>
                    <td><a href="{{ url('food/edit_eaten', $eda->id_eaten) }}" class="btn btn-warning">Update</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('food/create_eaten/'. Request::segment(3))}}"
           class="btn btn-primary">Create new eaten</a>
        <div>
            <a href="{{ url('user/day/'. $date)}}"
               class="btn btn-primary">Back</a>
        </div>
    </div>



@endsection