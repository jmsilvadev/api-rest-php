<?php
namespace Tests\Unit;

use App\DTO\DTOs\CoursesDTO;
use App\Models\Interfaces\DAOInterface;
use App\Repositories\Repositories\CoursesRepository;
use Exception;
use Codeception\Test\Unit;
use Mockery as m;
use Phalcon\Mvc\Model\Row;

class CoursesRepositoryTest extends Unit
{
    public $model;
    public $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = m::mock(DAOInterface::class);
        $this->repository = new CoursesRepository($this->model);
    }

    public function testShouldNotCreateDataWhenPostWithMissingParametersMethod()
    {
        $data = new CoursesDTO();
        $data->setId(1);
        $data->setName(null);

        $this->model->id = 1;
        $this->model->name = null;
        $this->model->email = null;
        $this->model->birth_at = null;
        $this->model->created_at = null;
        $this->model->modified_at = null;


        $this->model->shouldReceive('create')
            ->andReturn(false)
            ->once();

        $this->model->shouldReceive('getMessages')
            ->andReturn(['Error']);

        $this->model->shouldReceive('getPrimaryKeyValues')->once()->andReturnSelf();
        try {
            $this->repository->create($data);
        } catch (Exception $ex) {
            $this->assertInstanceOf(Exception::class, $ex);
        }

    }

    public function testShouldNotUpdateDataWhenPostWithMissingParametersMethod()
    {
        $data = new CoursesDTO();
        $data->setId(1);
        $data->setName(null);

        $mModel = m::mock(DAOInterface::class);

        $this->model->shouldReceive('findFirst')
            ->andReturn($mModel)
            ->once();

        $mModel->shouldReceive('update')
            ->andReturn(false)
            ->once();

        $this->model->shouldReceive('getPrimaryKeyValues')->once()->andReturnSelf();
        try {
            $this->repository->update($data);
        } catch (Exception $ex) {
            $this->assertInstanceOf(Exception::class, $ex);
        }

    }
    public function testShouldCreateDataWhenPostMethod()
    {
        $data = new CoursesDTO();
        $data->setId(1);
        $data->setName('Maslow');

        $this->model->id = 1;
        $this->model->name = 'Maslow';
        $this->model->created_at = null;
        $this->model->modified_at = null;


        $this->model->shouldReceive('create')
            ->andReturn(true)
            ->once();

        $this->model->shouldReceive('getPrimaryKeyValues')->once()->andReturnSelf();
        $result = $this->repository->create($data);

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('created_at', $result);
        $this->assertObjectHasAttribute('modified_at', $result);

        $this->assertEquals($data->getId(), $result->getId());
        $this->assertEquals($data->getName(), $result->getName());
        $this->assertEquals($data->getCreatedAt(), $result->getCreatedAt());
        $this->assertEquals($data->getModifiedAt(), $result->getModifiedAt());

    }

    public function testShouldUpdateDataWhenUpdateMethod()
    {
        $data = new CoursesDTO();
        $data->setId(1);
        $data->setName('Maslow');

        $this->model->id = 1;
        $this->model->name = 'Maslow';
        $this->model->created_at = null;
        $this->model->modified_at = null;

        $this->model->shouldReceive('findFirst')
            ->andReturn($this->model)
            ->once();

        $this->model->shouldReceive('update')
            ->andReturn(true)
            ->once();

        $this->model->shouldReceive('getPrimaryKeyValues')->once()->andReturnSelf();
        $result = $this->repository->update($data);

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('created_at', $result);
        $this->assertObjectHasAttribute('modified_at', $result);

        $this->assertEquals($data->getId(), $result->getId());
        $this->assertEquals($data->getName(), $result->getName());
        $this->assertEquals($data->getCreatedAt(), $result->getCreatedAt());
        $this->assertEquals($data->getModifiedAt(), $result->getModifiedAt());

    }

    /**
     * @dataProvider providerFind
     */
    public function testShouldReturnDataWhenUsingFindMethod($key, $status_code, $data)
    {

        $this->model->shouldReceive('getModelsMetaData')
            ->andReturnSelf();

        $this->model->shouldReceive('getAttributes')
            ->andReturn(['id','name']);

        $this->model->shouldReceive('find')
        ->andReturn([ $key => $status_code ])
        ->once();

        $this->model->shouldReceive('count')
                    ->andReturn([ $key => $status_code ]);

        $this->model->shouldReceive('setLimit')
        ->with($data["params"]["options"]["limit"])
        ->andReturn($data["params"]["options"]["limit"])
        ->once();

        $this->model->shouldReceive('setOffset')
        ->with($data["params"]["options"]["offset"])
        ->andReturn($data["params"]["options"]["offset"])
        ->once();

        $this->model->shouldReceive('getColumns')->once()->andReturnSelf();

        $this->repository->setLimit(10);
        $this->repository->setOffset(2);

        $result = $this->repository->find($data["query"], $data["params"]);
        $this->assertArrayHasKey($key, $result);
        $this->assertEquals($status_code, $result['status_code']);
    }

    public function testShouldReturnAnDataWhenUsingFindFisrtMethod()
    {

        $this->model->shouldReceive('getPrimaryKey')->andReturn('id');
        $this->model->shouldReceive('getColumns')->once()->andReturnSelf();

        $mModel = m::mock(Row::class);

        $this->model->shouldReceive('findFirst')
            ->andReturn($mModel)
            ->once();

        $result = $this->repository->findFirst(1);
        $this->assertInstanceOf(Row::class, $result);
    }

    public function testShouldReturnAThrowWhenUsingFindFisrtMethod()
    {

        $this->model->shouldReceive('getPrimaryKey')->andReturn('id');
        $this->model->shouldReceive('getColumns')->once()->andReturnSelf();

        $this->model->shouldReceive('findFirst')
            ->andReturn(false)
            ->once();

        try {
            $this->repository->findFirst(1);
        } catch (Exception $ex) {
            $this->assertInstanceOf(Exception::class, $ex);
        }

    }

    /**
     * @return array
     */
    public function providerFind()
    {

        return
        [
            [
                "status_code",
                "201",
                [
                    "query" => ["eq" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "",
                        "options" => ["limit" => 10, "offset" => 0]
                    ]
                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => [
                        "eq" => [
                            [
                                "name" => "john"
                            ],
                            [
                                "id" => "1"
                            ]
                        ]
                    ],
                    "params" =>[
                        "sort" => "",
                        "options" => ["limit" => 10, "offset" => 0]
                    ]
                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["not" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name asc",
                        "options" => ["limit" => 10, "offset" => 0]
                    ]
                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["lte" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name asc",
                        "options" => ["limit" => 10, "offset" => 0]
                    ]
                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["gte" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name desc",
                        "options" => ["limit" => 10, "offset" => 1]
                    ]
                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["gt" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name asc, id desc",
                        "options" => ["limit" => 10, "offset" => 1]
                    ]

                ]
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["lt" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name asc, id desc",
                        "options" => ["limit" => 10, "offset" => 1]
                    ]

                ]
            ]
        ];
    }
}
