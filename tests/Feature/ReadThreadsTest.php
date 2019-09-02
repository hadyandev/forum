<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test.
     *
     * @return void
     */

    public function testUserCanViewAllThreads()
    {
        $thread = factory('App\Thread')->create();

        // $response = $this->get('/threads');
        // $response->assertSee($thread->title);

        $this->get($thread->path())->assertSee($thread->title);

        // $response->assertStatus(200);
    }

    public function testUserCanReadSingleThread()
    {
        $thread = factory('App\Thread')->create();

        // $response = $this->get('threads/' . $thread->id);
        // $response->assertSee($thread->title);

        $this->get($thread->path())->assertSee($thread->title);
    }

    public function testUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $response = $this->get($thread->path())->assertSee($reply->body);
    }
}
