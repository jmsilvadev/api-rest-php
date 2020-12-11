<?php

namespace App\Controllers\CUDControllers;

use App\Controllers\BaseControllers\BaseCUDController;
use App\Controllers\Interfaces\ControllerInterface;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\DTO\DTOs\StudentsDTO;
use App\Models\Students;
use App\Repositories\Repositories\StudentsRepository;

class StudentsCUDController extends BaseCUDController implements ControllerInterface
{

    /**
     * {@inheritdoc}
     */
    public function onConstruct()
    {
        $this->repository = new StudentsRepository(new Students());
        $this->dto = (new DataTransformerObjectConverter(new StudentsDTO()))->apply($this->request);
    }
}
