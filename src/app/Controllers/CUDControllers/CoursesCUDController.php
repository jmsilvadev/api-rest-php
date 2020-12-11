<?php

namespace App\Controllers\CUDControllers;

use App\Controllers\BaseControllers\BaseCUDController;
use App\Controllers\Interfaces\ControllerInterface;
use App\DTO\DTOs\CoursesDTO;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\Models\Courses;
use App\Repositories\Repositories\CoursesRepository;

class CoursesCUDController extends BaseCUDController implements ControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onConstruct()
    {
        $this->repository = new CoursesRepository(new Courses());
        $this->dto = (new DataTransformerObjectConverter(new CoursesDTO()))->apply($this->request);
    }
}
