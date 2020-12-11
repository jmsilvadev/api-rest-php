<?php

namespace Tests\Unit;

use App\DTO\DTOs\StudentsCoursesDTO;
use Codeception\Test\Unit;
use stdClass;

class StudentsCoursesDTOTest  extends Unit
{
    public function testShouldPopulateDTOWhenUseItsMethods()
    {
        $dto = new StudentsCoursesDTO();
        $dto->setCourseId(1);
        $dto->setCouseName('Course');
        $dto->setStudentId(2);
        $dto->setStudentName('Student');

        $this->assertEquals(1, $dto->getCourseId());
        $this->assertEquals('Course', $dto->getCouseName());
        $this->assertEquals(2, $dto->getStudentId());
        $this->assertEquals('Student', $dto->getStudentName());


        $model = new stdClass();
        $model->student_id = 2;
        $model->student_name = 'Student';
        $model->course_id = 1;
        $model->course_name = 'Course';

        $dto = $dto->transform($model);
        $this->assertEquals(1, $dto->getCourseId());
        $this->assertEquals('Course', $dto->getCouseName());
        $this->assertEquals(2, $dto->getStudentId());
        $this->assertEquals('Student', $dto->getStudentName());
    }
}
