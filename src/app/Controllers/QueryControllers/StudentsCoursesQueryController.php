<?php

namespace App\Controllers\QueryControllers;

use App\Controllers\BaseControllers\BaseQueryController;
use App\Controllers\Interfaces\ControllerInterface;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\DTO\DTOs\StudentsCoursesDTO;
use App\Models\ViewStudentsCourses;
use App\Repositories\Repositories\StudentsRepository;

class StudentsCoursesQueryController extends BaseQueryController implements ControllerInterface
{

    /**
     * {@inheritdoc}
     */
    public function onConstruct()
    {
        $this->repository = new StudentsRepository(new ViewStudentsCourses());
        $this->dto = (new DataTransformerObjectConverter(new StudentsCoursesDTO()))->apply($this->request);
    }

    public function listStudents(int $courseId): array
    {
        $this->populateWhereClause();
        $this->arrWhere['eq'][] = ['course_id' => $courseId];
        $params = $this->getParams();
        if (!$params['fields']) {
            $params['fields'] = 'student_id,student_name';
        }

        return $this->repository->find($this->arrWhere, $params);
    }

    public function listCourses(int $studentId): array
    {

        $this->populateWhereClause();
        $this->arrWhere['eq'][] = ['student_id' => $studentId];
        $params = $this->getParams();
        if (!$params['fields']) {
            $params['fields'] = 'course_id,course_name';
        }

        return $this->repository->find($this->arrWhere, $params);
    }
}
