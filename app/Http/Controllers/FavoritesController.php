<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();

        // ga pindah halaman
        return back();
    }
}
