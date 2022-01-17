<?php

namespace Tests\Feature\SignUp\Emails;

use Tests\Feature\TestCase;

/**
 * @internal
 * @coversNothing
 */
class StoreTest extends TestCase
{
    public function test()
    {
        $this->when(function () {
            $this->setInputParam('nick', 'test1234');
            $this->setInputParam('password', '12345678');
            $this->setInputParam('email', 'dbwhddn10@daum.net');
        })->expectSuccess(function () {
        });
    }
}
