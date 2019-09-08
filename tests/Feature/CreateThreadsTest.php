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
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        // Given we have a signed in user
        // $this->actingAs(create('App\User')); // replaced by $this->signIn();
        $this->signIn(); // this method is in TestCase.php

        // When we hit the endpoint to create a new thread
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());

        // Then, we visit the thread page
        // We shoud see the new thread
        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);
    }
}
