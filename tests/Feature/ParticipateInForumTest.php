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
        // $this->expectException('Illuminate\Auth\AuthenticationException');
        // $thread = create('App\Thread');
        // $reply = create('App\Reply');
        // $this->post('/threads/some-channel/1/replies', []);

        $this->withExceptionHandling()->post('/threads/some-channel/1/replies', [])->assertRedirect('/login');
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
        // dd($thread->path() . '/replies'); //check result on test
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible in the page
        $this->get($thread->path())->assertSee($reply->body);
    }

    public function testAReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())->assertSessionHasErrors('body');
    }
}
