<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testGuestCanNotFavoriteAnything()
    {
        $this->withExceptionHandling()->post('replies/1/favorites')->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        // Choose or make any favorite endpoint you like. Here is the example.
        // /threads/channel/id/replies/id/favorites
        // /replies/id/favorites ( and in this tutorial, this is what we choose )
        // /replies/id/favorite
        // /favorites <-- reply_id in the request

        $reply = create('App\Reply');

        //  If I post to "favorite" endpoint
        $this->post('replies/' . $reply->id . '/favorites');

        // dd(\App\Favorite::all());

        //  It should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserMayOnlyFavoriteAReplyInce()
    {
        $this->signIn();
        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        // dd(\App\Favorite::all()->toArray());

        $this->assertCount(1, $reply->favorites);
    }
}
