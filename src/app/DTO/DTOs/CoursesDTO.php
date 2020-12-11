<?php

namespace App\DTO\DTOs;

use App\DTO\BaseDTOs\BaseDTO;
use App\DTO\Interfaces\DTOInterface;

class CoursesDTO extends BaseDTO implements DTOInterface
{
    protected ?int $id;
    protected ?string $name;
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
    public function convert(array $queryString, object $body): CoursesDTO
    {
        $this->dto = new CoursesDTO();
        return parent::convert($queryString, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($course): DTOInterface
    {
        $this->setId($course->id);
        $this->setName($course->name);
        $this->setCreatedAt($course->created_at);
        $this->setModifiedAt($course->modified_at);

        return $this;
    }
}
