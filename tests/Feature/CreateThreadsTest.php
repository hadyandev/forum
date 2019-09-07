<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testGuestMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        // Given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // When we hit the endpoint to create a new thread
        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());

        // Then, we visit the thread page
        // We shoud see the new thread
        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);
    }
}
