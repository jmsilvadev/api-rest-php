<?php

use Codeception\Util\HttpCode;

class StudentsControllerCest
{

    public function testIndex(ApiTester $I)
    {
        $I->sendGET('/students');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/students/?name=John,like&&limit=10&offset=1');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/students/1');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendGET('/students/99999');
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();
    }

    public function testShouldPopulateStudentsWhenPost(ApiTester $I)
    {
        $faker = Faker\Factory::create();
        $this->def_id = $faker->numberBetween(9000, 100000);
        $data = [
            'name' => 'John',
            'email' => 'john@gmail.com',
            'birth_at' =>  date('Y-m-d H:i:s'),
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/students', $data);
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
            'email' => 'john@gmail.com',
            'birth_at' =>  date('Y-m-d H:i:s'),
            'created_at' =>  date('Y-m-d H:i:s'),
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/students', $data);
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Date created and date modified are internal fields, please remove them from body.'
            ]
        );
    }

    public function testShouldPopulateStudentsWhenPut(ApiTester $I)
    {
        $data = [
            'name' => 'John',
            'email' => 'john@gmail.com',
            'birth_at' => date('Y-m-d H:i:s'),
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/students/1', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Updated successfully'
            ]
        );
    }
}
