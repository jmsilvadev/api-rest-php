<?php
namespace Tests\Unit;

use App\Models\Courses;
use Codeception\Test\Unit;

class CoursesTest extends Unit
{

    public $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Courses();
    }

    public function testShouldReturnPropertiesOfModelWhenUsingTheirMethod()
    {
        $this->assertEquals('id,name,created_at,modified_at', $this->model->getColumns());
        $this->assertEquals('id', $this->model->getPrimaryKey());
    }
}
