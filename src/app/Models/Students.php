<?php

namespace App\Models;

use App\Models\Interfaces\DAOInterface;
use App\Traits\TimestampableTrait;

class Students extends BaseModel implements DAOInterface
{
    use TimestampableTrait;

    public $id;
    public $name;
    public $email;
    public $birth_at;
    public $modified_at;
    public $created_at;
}
