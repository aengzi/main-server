<?php

namespace Tests\Feature\SignUp\Emails;

use Tests\Feature\_TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PostTest extends _TestCase
{
    protected $uri = 'sign-up/emails';

    public function test()
    {
        $this->when(function () {
            $this->setInputParameter('nick', 'test1234');
            $this->setInputParameter('password', 'abcd1234');
            $this->setInputParameter('email', 'dbwhddn10@daum.net');

            $this->runService();

            $this->assertNoError();
        });
    }
}
