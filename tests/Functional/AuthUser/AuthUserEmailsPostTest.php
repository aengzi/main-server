<?php

namespace Tests\Functional\AuthUser;

use FunctionalTest;

/**
 * @internal
 * @coversNothing
 */
class AuthUserEmailsPostTest extends FunctionalTest
{
    public $uri = 'auth-user/emails';

    public function test()
    {
        $this->when(function () {
            $this->setInputParameter('email', 'dbwhddn100@gmail.com');
            $this->setServerParameter('HTTP_AUTHORIZATION', 'Bearer eyJpdiI6IkxNcU9RNXJtVzZ1Ni1CRTQiLCJ0YWciOiJFX1E2U2lUaGZFdWg4ZUJwZ1VmbmhnIiwiYWxnIjoiQTEyOEdDTUtXIiwiZW5jIjoiQTEyOENCQy1IUzI1NiIsInppcCI6IkRFRiJ9.cBOpFEPeH4hq70XZQl4Tf7IkUqvcZ1n-I4EouBhyRNE.ua3pelhNNk5dQiUwNXLGzQ.paOobKpjN__1CXM20TbtVkPTFltmTRumDS0yPhQdtgv6fN27VmTlKN7SaXEn-MQoPW0qbKJbvuSQaTZOPIZ6rxJBU4bMtOXnEcFEqgbMkOLr-Jis2x5WsELIW1CfqbOJ.OjHNkzdGphMz6S3IqSGb5A');
            $this->runService();
        });
    }
}
