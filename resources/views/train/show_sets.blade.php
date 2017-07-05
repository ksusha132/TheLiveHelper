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
                <th>Set num</th>
                <th>Reps</th>
                <th>Weight</th>
                <th>Exercise</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            @foreach($sets as $set)
                <tr>
                    <td>{{{ $set->set_num }}}</td>
                    <td>{{{ $set->reps }}}</td>
                    <td>{{{ $set->weight }}}</td>
                    <td>{{{ $set->exercises->name }}}</td>
                    <td><a href="{{ url('train/delete_set', $set->id_set) }}" class="btn btn-danger">Delete</a></td>
                    <td><a href="{{ url('train/edit_set', $set->id_set) }}" class="btn btn-warning">Update</a></td>
                </tr>
            @endforeach
        </table>


        <form role="form" method="post" action="{{ url('train/create_set/'. Request::segment(3)) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="set_num">Set num</label>
                <input type="text" class="form-control" id="set_num" placeholder="Set num" name="set_num">
            </div>

            <div class="form-group">
                <label for="reps">Reps</label>
                <input type="text" class="form-control" id="reps" placeholder="Reps" name="reps">
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" class="form-control" id="weight" placeholder="weight" name="weight">
            </div>

            <div class="form-group">
                <label for="id_ex">Exercise</label>
                <select name="id_ex" class="form-control">
                    @foreach($exercises as $exercise)
                        <option value="{{{ $exercise->id_ex }}}">{{{ $exercise->name }}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-default">Send</button>
        </form>

        <div>
            <a href="{{ url('user/day/'.$date )}}"
               class="btn btn-primary">Back</a>
        </div>

    </div>




@endsection