<?php

namespace Tests\Unit;


use App\DTO\DTOs\CoursesDTO;
use App\DTO\DTOs\DataTransformerObjectConverter;
use App\DTO\DTOs\StudentsCoursesDTO;
use App\DTO\DTOs\StudentsDTO;
use Codeception\Test\Unit;
use Phalcon\Http\Request;
use Exception;
use Mockery as m;

class DataTransformerObjectConverterTest extends Unit
{
    public $transformer;
    public $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = m::mock(Request::class);
    }

    /**
     * @dataProvider providerDTO
     */
    public function testShouldApllyDTOWhenReceiveNewRequestToDTO($dtoName, $arrJson, $arrQuery, $arrQuery2)
    {

        $dtoTransformer = new DataTransformerObjectConverter(new $dtoName);

        $this->request->shouldReceive('isGet')
            ->andReturn(false)
            ->once();

        $this->request->shouldReceive('getJsonRawBody')
            ->andReturn((object) $arrJson)
            ->once();

        $this->request->shouldReceive('getQuery')
            ->andReturn($arrQuery)
            ->once();

        $dto = $dtoTransformer->apply($this->request);
        $this->assertInstanceOf($dtoName, $dto);

        if ($dtoName != StudentsCoursesDTO::class) {
            $this->assertEquals(1, $dto->getId());
            $this->assertEquals('John', $dto->getName());
        }

        if ($dtoName == StudentsCoursesDTO::class) {
            $this->assertEquals(1, $dto->getStudentId());
        }

        $this->request->shouldReceive('getJsonRawBody')
            ->andReturn((object) ['xpto' => 1, 'nameNonExistent' => 'John'])
            ->once();

        try {
            $dtoTransformer->apply($this->request);
        } catch (Exception $ex) {
            $this->assertInstanceOf(Exception::class, $ex);
        }

        $this->request->shouldReceive('getQuery')
            ->andReturn($arrQuery2)
            ->once();

        try {
            $dtoTransformer->apply($this->request);
        } catch (Exception $ex) {
            $this->assertInstanceOf(Exception::class, $ex);
        }
    }

    /**
     * @return array
     */
    public function providerDTO()
    {

        return
            [
                [
                    StudentsDTO::class,
                    ['id' => 1, 'name' => 'John'],
                    ['_url' => '/students/', 'name' => 'John'],
                    ['_url' => '/students/', 'sort' => 'John'],
                ],
                [
                    CoursesDTO::class,
                    ['id' => 1, 'name' => 'John'],
                    ['_url' => '/courses/', 'name' => 'John'],
                    ['_url' => '/courses/', 'sort' => 'John'],
                ],
                [
                    StudentsCoursesDTO::class,
                    ['student_id' => 1],
                    ['_url' => '/courses/1/students', 'student_id' => 1],
                    ['_url' => '/courses/1/students', 'sort' => 'student_id'],
                ]
            ];
    }

}
