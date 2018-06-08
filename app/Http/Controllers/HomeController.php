<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Mail\PostComments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->get();
        return view('home', compact('posts'));
    }

    function post(Request $request, Post $post)
    {
        return view('post', compact('post'));
    }

    function sendMail(Post $post)
    {

        Mail::to('test@test.com')->send(new PostComments($post));

        echo 'Mail Sent';
    }
}
