@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Access</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Roles</h3>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action">
                                    <form method="POST" action="{{ route('access.role.store') }}">
                                        @csrf
                                        <div class="input-group mb-n3">
                                            <input type="text" class="form-control" name="new_role" placeholder="Add New Role +" aria-label="New Role" aria-describedby="new-role">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit" id="new-role">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                                @foreach($roles as $role)
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        {{ $role->name }}
                                        @if($role->name != config('access.default.role'))
                                            <form method="POST" action="{{ route('access.role.destroy', $role->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                            </form>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h3>Permissions</h3>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action">
                                    <form method="POST" action="{{ route('access.permission.store') }}">
                                        @csrf
                                        <div class="input-group mb-n3">
                                            <input type="text" class="form-control" name="new_permission" placeholder="Add New Permission +" aria-label="New Permission" aria-describedby="new-permission">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit" id="new-permission">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                                @foreach($permissions as $permission)
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        {{ $permission->name }}
                                        <form method="POST" action="{{ route('access.permission.destroy', $permission->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
