<?php

namespace App\DTO\DTOs;

use App\DTO\BaseDTOs\BaseDTO;
use App\DTO\Interfaces\DTOInterface;

class StudentsDTO extends BaseDTO implements DTOInterface
{

    protected ?int $id;
    protected ?string $name;
    protected ?string $email;
    protected ?string $birth_at;
    protected ?string $modified_at;
    protected ?string $created_at;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBirthAt()
    {
        return $this->birth_at;
    }

    /**
     * @param mixed $birth_at
     */
    public function setBirthAt($birth_at): void
    {
        $this->birth_at = $birth_at;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * @param mixed $modified_at
     */
    public function setModifiedAt($modified_at): void
    {
        $this->modified_at = $modified_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(array $queryString, object $body): StudentsDTO
    {
        $this->dto = new StudentsDTO();
        return parent::convert($queryString, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($model): DTOInterface
    {
        $this->setId($model->id);
        $this->setName($model->name);
        $this->setBirthAt($model->birth_at);
        $this->setEmail($model->email);
        $this->setCreatedAt($model->created_at);
        $this->setModifiedAt($model->modified_at);

        return $this;
    }
}
