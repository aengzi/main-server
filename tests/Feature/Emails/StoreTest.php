<?php

namespace Tests\Feature\Emails;

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
            $this->setInputParam('subject', 'hello world');
            $this->setInputParam('body', 'hi~!');
            $this->setInputParam('email', 'dbwhddn10@daum.net');
        })->expectSuccess(function () {
        });
    }
}
