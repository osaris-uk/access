<!doctype html>
<html lang="en">
    <head>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>

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
                                                <div class="input-group">
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
                                                <div class="input-group">
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

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
