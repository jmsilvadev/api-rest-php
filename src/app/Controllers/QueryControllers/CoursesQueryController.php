<?php

namespace App\Controllers\QueryControllers;

use App\Controllers\BaseControllers\BaseQueryController;
use App\Controllers\Interfaces\ControllerInterface;
use App\DTO\DTOs\CoursesDTO;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\Models\Courses;
use App\Repositories\Repositories\CoursesRepository;

class CoursesQueryController extends BaseQueryController implements ControllerInterface
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
