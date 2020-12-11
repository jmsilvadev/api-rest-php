<?php
namespace Tests\Unit;

use App\Models\StudentsCourses;
use Codeception\Test\Unit;

class StudentsCoursesTest extends Unit
{

    public $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new StudentsCourses();
    }

    public function testShouldReturnPropertiesOfModelWhenUsingTheirMethod()
    {
        $this->assertEquals('course_id,student_id', $this->model->getColumns());
        $this->assertEquals('course_id', $this->model->getPrimaryKey());
    }
}
