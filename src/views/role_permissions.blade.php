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
                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                            </form>
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
