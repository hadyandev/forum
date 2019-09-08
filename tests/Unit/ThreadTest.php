<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testAThreadCanMakeAStringPath()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    public function testAThreadHasACreator()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\User', $thread->creator);
    }

    public function testAthreadHasReplies()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function testAThreadCanAddAReply()
    {
        $thread = create('App\Thread');
        $thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $thread->replies);
    }

    public function testAThreadBelongsToAChannel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}
