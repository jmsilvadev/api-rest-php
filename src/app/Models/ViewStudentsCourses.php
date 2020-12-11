<?php

namespace App\Models;

use App\Models\Interfaces\DAOInterface;

class ViewStudentsCourses extends BaseModel implements DAOInterface
{
    public $student_id;
    public $student_name;
    public $course_id;
    public $couse_name;
}
