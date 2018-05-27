## Usage

After running the migrations, you can start using the package by adding the `AccessTrait` trait to your user model.

```php
use OsarisUk\Access\AccessTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AccessTrait;
}
```