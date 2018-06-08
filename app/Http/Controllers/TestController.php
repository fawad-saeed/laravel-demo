<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Http\Resources\PostCollection;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    function test()
    {
        echo Redis::get('user:213:name');
    }

    function getComments(Post $post)
    {
        return new PostCollection($post->comments()->with('user')->latest()->paginate(15));
    }

    function store(Request $request, Post $post)
    {
        $comment = $post->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        $comment = Comment::where('id', $comment->id)->with('user')->first();

        event(new NewComment($comment));

        return $comment->toJson();
    }
}
