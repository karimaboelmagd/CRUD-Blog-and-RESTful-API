<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use http\Env\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('category')->latest()->get(); //    order categories by latest
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));

    }


    public function store(StorePostRequest $request) //store(Request $request)
    {
//        $post = new Post($request->all());
//        $post->category_id = $request->category_id;
//        $post->save();
//        return redirect()->route('posts.index')->with('success', 'Post created successfully.');

        $request->validate([
        'title' => 'required',
        'body' => 'required',
        'category_id' => 'required|exists:categories,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $input = $request->all();

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('public/photos');
        $input['photo'] = basename($path);
    }
    Post::create($input);
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


    public function update(StorePostRequest $request, $id) //update(Request $request, Post $post)
    {

        try {
            $post = Post::findorFail($id);

            $post->update($request->all());

            return redirect()->back()->with('edit', 'Data Updated successfully');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
//        $validatedData = $request->validate([
//            'title' => 'required|max:255',
//            'content' => 'required',
//            'category_id' => 'required|exists:categories,id',
//            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        // Handle photo and update logic as before...
//
//        $post->update($validatedData);
//
//        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
//    }
        //------------------------------------
//        $request->validate([
//            'title' => 'required',
//            'content' => 'required',
//            'category_id' => 'required|exists:categories,id',
//        ]);
//
//        $post->update($request->all());
//
//        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');


    }



    public function destroy($id) //destroy(Post $post)
    {
        try {

            Post::destroy($id);
            return redirect()->back()->with('delete', 'Data has been deleted successfully');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

//        $post->delete();
//        return back()->with('success', 'Post deleted successfully.');
    }
}
