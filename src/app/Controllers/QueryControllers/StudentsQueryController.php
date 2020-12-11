<?php

namespace App\Controllers\QueryControllers;

use App\Controllers\BaseControllers\BaseQueryController;
use App\Controllers\Interfaces\ControllerInterface;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\DTO\DTOs\StudentsDTO;
use App\Models\Students;
use App\Repositories\Repositories\StudentsRepository;

class StudentsQueryController extends BaseQueryController implements ControllerInterface
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
