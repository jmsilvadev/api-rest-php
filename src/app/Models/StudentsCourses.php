<?php

namespace App\Models;

use App\Models\Interfaces\DAOInterface;

class StudentsCourses extends BaseModel implements DAOInterface
{

    public $student_id;
    public $course_id;
}
