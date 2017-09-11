<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['new', 'store']);
	}

	public function index()
	{
		$posts = Post::paginate(8);

		return view('home', compact('posts'));
	}

    public function show(Post $post)
    {
    	return view('post', compact('post'));
    }

    public function new()
    {
    	return view('new');
    }

    public function store(Request $request)
    {
    	Post::create($request->all());

    	return redirect('/');
    }
}
