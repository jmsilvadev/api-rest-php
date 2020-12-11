<?php

use Codeception\Util\HttpCode;

class OpenAPICest
{

    public function testIndex(ApiTester $I)
    {
        $I->sendGET('/oas');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
