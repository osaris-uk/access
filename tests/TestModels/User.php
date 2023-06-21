<?php

namespace OsarisUk\Access\Tests\TestModels;

use OsarisUk\Access\AccessTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use AccessTrait;
}
