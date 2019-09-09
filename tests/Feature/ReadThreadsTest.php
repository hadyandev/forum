<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test.
     *
     * @return void
     */

    public function testUserCanViewAllThreads()
    {
        $thread = create('App\Thread');

        // $response = $this->get('/threads');
        // $response->assertSee($thread->title);

        $this->get($thread->path())->assertSee($thread->title);

        // $response->assertStatus(200);
    }

    public function testUserCanReadSingleThread()
    {
        $thread = create('App\Thread');

        // $response = $this->get('threads/' . $thread->id);
        // $response->assertSee($thread->title);

        $this->get($thread->path())->assertSee($thread->title);
    }

    public function testUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $thread = create('App\Thread');

        // $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $response = $this->get($thread->path())->assertSee($reply->body);
    }

    public function testAUserCanFilterThreadsAccordingToAChannel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

}
