@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Roles</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('access.roles') }}">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">User</th>
                                    @foreach($roles as $role)
                                        <th scope="col" class="text-center">{{ $role->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->name }}</th>
                                        @foreach($roles as $role)
                                            <td class="text-center"><input type="checkbox" name="userRoles[{{$user->id}}][{{$role->name}}]" value="true" {{ $user->hasRole($role->name) ? 'checked' : '' }} {!! $role->name === config('access.default.role') ? 'onclick="return false;"' : '' !!}></td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                @csrf
                            </tbody>
                        </table>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
