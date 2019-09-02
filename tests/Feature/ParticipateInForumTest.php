<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUnaunthenticatedUsersMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post('/threads/1/replies', []);
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        // Given we have an authenticated user
        $this->be($user = factory('App\User')->create());
        // $user = factory('App\User')->create();

        // And an existing thread
        $thread = factory('App\Thread')->create();

        // When the user adds a reply to the thread
        $reply = factory('App\Reply')->make();
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible in the page
        $this->get($thread->path())->assertSee($reply->body);
    }
}
