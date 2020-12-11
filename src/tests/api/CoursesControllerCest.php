<?php

use Codeception\Util\HttpCode;

class CoursesControllerCest
{
    public function testIndex(ApiTester $I)
    {
        $I->sendGET('/courses');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/courses/?name=John,like&&limit=10&offset=1');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/courses/1');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/courses/99999');
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();

    }

    public function testShouldPopulateCoursesWhenPost(ApiTester $I)
    {
        $faker = Faker\Factory::create();
        $this->def_id = $faker->numberBetween(9000, 100000);
        $data = [
            'name' => 'John',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/courses', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Created successfully'
            ]
        );
    }

    public function testShouldShowAnErrorStudentsWhenPostInternalDates(ApiTester $I)
    {
        $faker = Faker\Factory::create();
        $this->def_id = $faker->numberBetween(9000, 100000);
        $data = [
            'name' => 'John',
            'created_at' =>  date('Y-m-d H:i:s'),
            'modified_at' =>  date('Y-m-d H:i:s'),
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/courses', $data);
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Date created and date modified are internal fields, please remove them from body.'
            ]
        );
    }

    public function testShouldPopulateCoursesWhenPut(ApiTester $I)
    {
        $data = [
            'name' => 'John',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/courses/1', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Updated successfully'
            ]
        );
    }
}
