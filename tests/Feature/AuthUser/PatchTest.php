<?php

namespace Tests\Feature\Emails;

use App\Models\User;
use Tests\Feature\_TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PatchTest extends _TestCase
{
    protected $uri = 'auth-user';

    public function test()
    {
        $this->when(function () {
            $user = User::factory()->create(['id' => 1]);

            $this->setAuthUser(User::find(1));
            $this->setInputParameter('nick', 'hello-world');
            $this->setInputParameter('password', 'Abcd1234~!');

            $this->runService();

            $this->assertNoError();
            $result = $this->service->getData()->getArrayCopy()['result'];

            $this->assertEquals($result->nick, 'hello-world');
            $this->assertNotEquals($user->password, $result->password);
        });
    }
}
