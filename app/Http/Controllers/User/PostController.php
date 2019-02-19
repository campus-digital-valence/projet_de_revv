<?php

namespace App\Http\Controllers\User;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'asc')->paginate();

        return view('user.post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateRequest = $request->validate([
            'title' => 'string|max:150|required',
            'text_content' => 'required',
            'status' => 'required',
        ]);

        $title = $validateRequest['title'];
        $content = $validateRequest['text_content'];
        $status = $validateRequest['status'];
        $user = Auth::user()->id;
        $validateRequest['user_id'] = $user;

        Post::Create($validateRequest);

        return redirect(route('user.post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('post.title')
            ->load('post.status')
            ->load('post.user_id')
            ->load('post.text_content')
            ->load('post.update_at');

        return view('user.post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $user = Auth::user();

        return view('user.post.edit', ['user' => $user, 'post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function beforeDelete(Post $post)
    {
        return view('user.post.beforedelete', ['post' => $post]);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function softDelete(Post $post)
    {
        $post->delete();

        return redirect()->route('home')->with('message', $post->title.' supprimé !');
    }
}
