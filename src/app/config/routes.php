<?php

use App\Controllers\CacheController;
use App\Controllers\CUDControllers\CoursesCUDController;
use App\Controllers\CUDControllers\StudentsCUDController;
use App\Controllers\OpenAPIController;
use App\Controllers\QueryControllers\CoursesQueryController;
use App\Controllers\QueryControllers\StudentsCoursesQueryController;
use App\Controllers\QueryControllers\StudentsQueryController;
use Phalcon\Mvc\Micro\Collection;

$collection = new Collection();
$collection->setHandler(StudentsQueryController::class, true);
$collection->setPrefix('/students');
$collection->get('/{student_id}', 'show');
$collection->get('/', 'list');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(StudentsCUDController::class, true);
$collection->setPrefix('/students');
$collection->mapVia('/{student_id}', 'update', [ 'PUT', 'OPTIONS' ]);
$collection->post('/', 'create');
$collection->put('/{student_id}', 'update');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(CoursesQueryController::class, true);
$collection->setPrefix('/courses');
$collection->get('/{id}', 'show');
$collection->get('/', 'list');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(CoursesCUDController::class, true);
$collection->setPrefix('/courses');
$collection->mapVia('/{id}', 'update', [ 'PUT', 'OPTIONS' ]);
$collection->post('/', 'create');
$collection->put('/{course_id}', 'update');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(StudentsCoursesQueryController::class, true);
$collection->get('/courses/{course_id}/students', 'listStudents');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(StudentsCoursesQueryController::class, true);
$collection->get('/students/{student_id}/courses', 'listCourses');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(CacheController::class, true);
$collection->setPrefix('/cache');
$collection->delete('/', 'clearAll');
$collection->delete('/{tag}', 'clearAll');
$app->mount($collection);

$collection = new Collection();
$collection->setHandler(OpenAPIController::class, true);
$collection->setPrefix('/oas');
$collection->get('/', 'index');
$app->mount($collection);
