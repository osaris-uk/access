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

Views can also be published with:

```bash
php artisan vendor:publish --provider="OsarisUk\Access\AccessServiceProvider" --tag="views"
```