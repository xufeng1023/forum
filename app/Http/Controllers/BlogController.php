<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['new', 'store']);
	}

	public function index()
	{
		$blogs = Blog::latest()->paginate(8);

		return view('home', compact('blogs'));
	}

    public function show(Blog $blog)
    {
    	return view('blog', compact('blog'));
    }

    public function new()
    {
    	return view('new');
    }

    public function store(Request $request)
    {
    	Blog::create($request->all());

    	return redirect('/');
    }
}
