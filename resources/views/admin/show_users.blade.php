@extends('layouts.app')
@section('title', 'Show users')
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
        <table class="table table-bordered">
            <thead>
            <th>Name</th>
            <th>Email</th>
            <th>User</th>
            <th>Trainer</th>
            <th>Admin</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <form action="{{ route('admin.SaveRoles') }}" method="post">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}<input type="hidden" name="email" value="{{ $user->email }}"></td>
                        <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : ''}} name="role_user"></td>
                        <td><input type="checkbox" {{ $user->hasRole('Trainer') ? 'checked' : ''}} name="role_trainer">
                        </td>
                        <td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"></td>
                        {{ csrf_field() }}
                        <td>
                            <button type="submit" class="btn btn-success">Apply</button>
                        </td>

                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>
@endsection