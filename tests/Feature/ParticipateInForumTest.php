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
        $thread = create('App\Thread');
        $reply = create('App\Reply');
        $this->post('/threads/1/replies', []);
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        // Given we have an authenticated user
        $this->be($user = create('App\User'));
        // $user = factory('App\User')->create();

        // And an existing thread
        $thread = create('App\Thread');

        // When the user adds a reply to the thread
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible in the page
        $this->get($thread->path())->assertSee($reply->body);
    }
}
