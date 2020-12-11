<?php

use Codeception\Util\HttpCode;

class CacheControllerCest
{
    public function testShouldPopulateCacheWhenCalled(ApiTester $I)
    {
        $faker = Faker\Factory::create();
        $def_id = $faker->numberBetween(9000, 100000);
        $data = [
            "id" => $def_id,
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

        $I->sendGET('/courses/');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }

    public function testShouldClearAllCacheWhenReceiveADeleteRequest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/cache');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Flush cache successfully'
            ]
        );
    }

    public function testShouldNotClearTagCacheCacheWhenReceiveAWrongTag(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/cache/student');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Deleted tags: 0'
            ]
        );
    }

}
