# Osaris UK - Access

## Usage

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

You can publish the config file with:

```bash
php artisan vendor:publish --provider="OsarisUk\Access\AccessServiceProvider" --tag="config"
```

## Middleware

This package ships with `AccessMiddleware`.  This allows you to protect your routes granting access to users with specific roles:

```php
Route::group(['middleware' => ['access:admin']], function () {
    //
});

Route::group(['middleware' => ['access:user']], function () {
    //
});
```

You can also grant access to users with specific permissions:

```php
Route::group(['middleware' => ['access:user,create posts']], function () {
    //
});

Route::group(['middleware' => ['access:user,delete posts']], function () {
    //
});
```