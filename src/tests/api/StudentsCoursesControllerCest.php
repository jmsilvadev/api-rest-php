<?php

use Codeception\Util\HttpCode;

class StudentsCoursesControllerCest
{

    public function testIndex(ApiTester $I)
    {
        $I->sendGET('/students/1/courses');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/courses/1/students');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/courses/1/students/?course_id=1&limit=10&offset=1');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }
}
