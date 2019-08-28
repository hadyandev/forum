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

        $response = $this->get('/threads');
        $response->assertSee($thread->title);

        // $response->assertStatus(200);
    }

    public function testUserCanReadSingleThread()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
