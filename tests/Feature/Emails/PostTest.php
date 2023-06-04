<?php

namespace Tests\Feature\Emails;

use Tests\Feature\_TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PostTest extends _TestCase
{
    protected $uri = 'emails';

    public function test()
    {
        $this->when(function () {
            $this->setInputParameter('subject', 'hello world');
            $this->setInputParameter('body', 'hi~!');
            $this->setInputParameter('email', 'dbwhddn10@daum.net');

            $this->runService();

            $this->assertNoError();
        });
    }
}
