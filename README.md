# Osaris UK - Access

## Usage

For Laravel 5.5 - 5.7 use v1.3.2

After running the migrations, you can start using the package by adding the `AccessTrait` to your user model.

```php
use OsarisUk\Access\AccessTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AccessTrait;
}
```

By default all user accounts will be created with the 'user' role, this can be configured in the access config.

You can publish the config file with:

```bash
php artisan vendor:publish --provider="OsarisUk\Access\AccessServiceProvider" --tag="config"
```


## Middleware

This package ships with `AccessMiddleware`.  This allows you to protect your routes allowing access to users with specific roles:

```php
Route::group(['middleware' => ['access:admin']], function () {
    //
});

Route::group(['middleware' => ['access:user']], function () {
    //
});
```

You can also allow access to users with specific permissions:

```php
Route::group(['middleware' => ['access:user,create posts']], function () {
    //
});

Route::group(['middleware' => ['access:user,remove posts']], function () {
    //
});
```

## Blade Directives

This package integrates with the default Laravel Blade directive `@can`, this allows you to show content based on a users assigned permission including permissions they have been assigned through a role:

```html
@can('edit posts')
    <a href="#">Edit Post</a>
@endcan
```

There is also a `@role` Blade directive included in this package, this allows you to show content based on a users assigned role:

```html
@role('moderator')
    <a href="#">Remove Post</a>
@endrole
```

## Available Methods

```php
giveRoles(...$roles)
withdrawRoles(...$roles)
updateRoles(...$roles)
givePermissionTo(...$permissions)
withdrawPermissionTo(...$permissions)
updatePermissions(...$permissions)
hasRole(...$roles)
hasPermissionTo($permission)
```