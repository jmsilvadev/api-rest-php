<?php
namespace Tests\Unit;

use App\Models\Students;
use Codeception\Test\Unit;

class StudentsTest extends Unit
{

    public $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Students();
    }

    public function testShouldReturnPropertiesOfModelWhenUsingTheirMethod()
    {
        $this->assertEquals('id,name,email,birth_at,created_at,modified_at', $this->model->getColumns());
        $this->assertEquals('id', $this->model->getPrimaryKey());
    }
}
