<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('category')->latest()->get(); //    Eager Loading to avoid N+1 Problem
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));

    }


    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = new Post($request->all());
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');

}


    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }


    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));

    }


    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $post->update($validatedData);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');

    }

    public function destroy(Post $post)
    {

        $post->delete();
        return back()->with('success', 'Post deleted successfully.');

    }
}
