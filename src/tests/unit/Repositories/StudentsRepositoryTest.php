<?php
namespace Tests\Unit;


use App\DTO\DTOs\StudentsDTO;
use App\Models\Interfaces\DAOInterface;
use App\Repositories\Repositories\StudentsRepository;
use Exception;
use Codeception\Test\Unit;
use Mockery as m;
use Phalcon\Mvc\Model\Row;

class StudentsRepositoryTest extends Unit
{
    public $model;
    public $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = m::mock(DAOInterface::class);
        $this->repository = new StudentsRepository($this->model);
    }

    public function testShouldNotCreateDataWhenPostWithMissingParametersMethod()
    {
        $data = new StudentsDTO();
        $data->setId(1);
        $data->setName(null);
        $data->setEmail(null);
        $data->setBirthAt(date('Y-m-d H:i:s'));

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
        $data = new StudentsDTO();
        $data->setId(1);
        $data->setName(null);
        $data->setEmail(null);
        $data->setBirthAt(date('Y-m-d H:i:s'));

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
        $data = new StudentsDTO();
        $data->setId(1);
        $data->setName('Maslow');
        $data->setEmail('teste@gmail.com');
        $data->setBirthAt(date('Y-m-d H:i:s'));

        $this->model->id = 1;
        $this->model->name = 'Maslow';
        $this->model->email = null;
        $this->model->birth_at = null;
        $this->model->created_at = null;
        $this->model->modified_at = null;


        $this->model->shouldReceive('create')
            ->andReturn(true)
            ->once();

        $this->model->shouldReceive('getPrimaryKeyValues')->once()->andReturnSelf();
        $result = $this->repository->create($data);

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('email', $result);
        $this->assertObjectHasAttribute('birth_at', $result);
        $this->assertObjectHasAttribute('created_at', $result);
        $this->assertObjectHasAttribute('modified_at', $result);

        $this->assertEquals($data->getId(), $result->getId());
        $this->assertEquals($data->getName(), $result->getName());
        $this->assertEquals($data->getEmail(), $result->getEmail());
        $this->assertEquals($data->getBirthAt(), $result->getBirthAt());
        $this->assertEquals($data->getCreatedAt(), $result->getCreatedAt());
        $this->assertEquals($data->getModifiedAt(), $result->getModifiedAt());

    }

    public function testShouldUpdateDataWhenUpdateMethod()
    {
        $data = new StudentsDTO();
        $data->setId(1);
        $data->setName('Maslow');
        $data->setEmail('teste@gmail.com');
        $data->setBirthAt(date('Y-m-d H:i:s'));

        $this->model->id = 1;
        $this->model->name = 'Maslow';
        $this->model->email = null;
        $this->model->birth_at = null;
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
        $this->assertObjectHasAttribute('email', $result);
        $this->assertObjectHasAttribute('birth_at', $result);
        $this->assertObjectHasAttribute('created_at', $result);
        $this->assertObjectHasAttribute('modified_at', $result);

        $this->assertEquals($data->getId(), $result->getId());
        $this->assertEquals($data->getName(), $result->getName());
        $this->assertEquals($data->getEmail(), $result->getEmail());
        $this->assertEquals($data->getBirthAt(), $result->getBirthAt());
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

        if ($status_code == '201') {
            $result = $this->repository->find($data["query"], $data["params"]);
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($status_code, $result['status_code']);
        }

        if ($status_code == '409') {
            $this->model->shouldReceive('find')
                ->andReturn(false);

            try {
                $this->repository->find($data["query"], $data["params"]);
            } catch (Exception $ex) {
                $this->assertInstanceOf(Exception::class, $ex);
            }
        }
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
                        "fields" => "id,name",
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
            ],
            [
                "status_code",
                "201",
                [
                    "query" => ["like" => [[ "name" => "john" ]]],
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
                    "query" => ["in" => [[ "name" => "john" ]]],
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
                    "query" => ["is" => [[ "name" => "john" ]]],
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
                    "query" => ["" => [[ "name" => "john" ]]],
                    "params" =>[
                        "sort" => "name asc, id desc",
                        "options" => ["limit" => 10, "offset" => 1]
                    ]

                ]
            ],
            [
                "status_code",
                "409",
                [
                    "query" => ["lt" => [[ "name" => "john" ]]],
                    "params" =>[
                        "fields" => 'non-existent',
                        "sort" => "name asc, id desc",
                        "source" => true,
                        "options" => ["limit" => 10, "offset" => 1]
                    ]

                ]
            ]
        ];
    }
}
