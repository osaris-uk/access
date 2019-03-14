@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Role Permissions</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('access.rolepermissions') }}">
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
                                @foreach($permissions as $permission)
                                    <tr>
                                        <th scope="row">{{ $permission->name }}</th>
                                        @foreach($roles as $role)
                                            <td class="text-center"><input type="checkbox" name="rolePermissions[{{$role->id}}][{{$permission->name}}]" value="true" {{ $role->hasPermission($permission->name) ? 'checked' : '' }}></td>
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
