<?php

namespace App\Models;

use App\Models\Interfaces\DAOInterface;
use App\Traits\TimestampableTrait;

class Courses extends BaseModel implements DAOInterface
{
    use TimestampableTrait;

    public $id;
    public $name;
    public $modified_at;
    public $created_at;
}
