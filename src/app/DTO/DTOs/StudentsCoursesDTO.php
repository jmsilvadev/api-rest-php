<?php

namespace App\DTO\DTOs;

use App\DTO\BaseDTOs\BaseDTO;
use App\DTO\Interfaces\DTOInterface;

class StudentsCoursesDTO extends BaseDTO implements DTOInterface
{

    protected ?int $student_id;
    protected ?string $student_name;
    protected ?int $course_id;
    protected ?string $couse_name;

    /**
     * @return int|null
     */
    public function getStudentId(): ?int
    {
        return $this->student_id;
    }

    /**
     * @param int|null $student_id
     */
    public function setStudentId(?int $student_id): void
    {
        $this->student_id = $student_id;
    }

    /**
     * @return string|null
     */
    public function getStudentName(): ?string
    {
        return $this->student_name;
    }

    /**
     * @param string|null $student_name
     */
    public function setStudentName(?string $student_name): void
    {
        $this->student_name = $student_name;
    }

    /**
     * @return int|null
     */
    public function getCourseId(): ?int
    {
        return $this->course_id;
    }

    /**
     * @param int|null $course_id
     */
    public function setCourseId(?int $course_id): void
    {
        $this->course_id = $course_id;
    }

    /**
     * @return string|null
     */
    public function getCouseName(): ?string
    {
        return $this->couse_name;
    }

    /**
     * @param string|null $couse_name
     */
    public function setCouseName(?string $couse_name): void
    {
        $this->couse_name = $couse_name;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(array $queryString, object $body): StudentsCoursesDTO
    {
        $this->dto = new StudentsCoursesDTO();
        return parent::convert($queryString, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($studentCourse): DTOInterface
    {
        $this->setStudentId($studentCourse->student_id);
        $this->setStudentName($studentCourse->student_name);
        $this->setCourseId($studentCourse->course_id);
        $this->setCouseName($studentCourse->course_name);

        return $this;
    }
}
