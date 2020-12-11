<?php

namespace App\Repositories\Repositories;

use App\DTO\Interfaces\DTOInterface;
use App\Repositories\BaseRepositories\BaseRepository;
use App\Repositories\Interfaces\CUDRepositoryInterface;
use Exception;

class StudentsRepository extends BaseRepository implements CUDRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(DTOInterface $dto): ?DTOInterface
    {

        $this->model->name = $dto->getName();
        $this->model->email = $dto->getEmail();
        $this->model->birth_at = $dto->getBirthAt();

        if (!$this->model->create()) {
            throw new Exception('Error: ' . implode($this->model->getMessages(), ' | '));
        }

        return $dto->transform($this->model);
    }

    /**
     * {@inheritdoc}
     */
    public function update(DTOInterface $dto): ?DTOInterface
    {
        $model = $this->model->findFirst('id = ' . $dto->getId());
        $model->name = $dto->getName();
        $model->email = $dto->getEmail();
        $model->birth_at = $dto->getBirthAt();

        if (!$model->update()) {
            throw new Exception('Error: ' . implode($this->model->getMessages(), ' | '));
        }

        return $dto->transform($model);
    }
}
