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

    public function testGuestsMayNotCreateThreads()
    {
        // defaultnya adalah tanpa exception handling. settingnya ada di test case
        $this->withExceptionHandling();
        // guest cannot see create thread page
        $this->get('/threads/create')->assertRedirect('/login');
        // guest cannot create thread
        $this->post('/threads')->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        // Given we have a signed in user
        // $this->actingAs(create('App\User')); // replaced by $this->signIn();
        $this->signIn(); // this method is in TestCase.php

        // When we hit the endpoint to create a new thread
        // $thread = create('App\Thread');
        // $this->post('/threads', $thread->toArray());

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        // Then, we visit the thread page
        // We shoud see the new thread
        // $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);

        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }

    public function testAThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    public function testAThreadRequiresABody()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    public function testAThreadRequiresAValidChannel()
    {
        factory('App\Channel', 2)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 999])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        // validate everything that is required
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
