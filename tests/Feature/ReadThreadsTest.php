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

    public function testAUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')->assertSee($threadByJohn->title)->assertDontSee($threadNotByJohn->title);
    }

    public function testAUserCanFilterThreadsByPopularity()
    {
        // Given we have three threads
        // With 2 replies, 3 replies, and 0 replies respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = create('App\Thread');

        // When I filter all threads by popularity
        $response = $this->getJson('threads?popular=1')->json();

        // Then they should be returned from most replies to least.
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

}
