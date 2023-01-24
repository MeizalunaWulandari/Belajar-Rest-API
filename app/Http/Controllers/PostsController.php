<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return PostDetailResource::collection($posts->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,comments_content']));

    }

    public function show($id)
    {
        // NOTE : findOrFail harus diakhir
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    public function store(Request $request)
    {
        // return $request->file;

        $validatedData = $request->validate([
            'title' => ['required', 'max:200'],
            'image' => 'image|file|max:1024',
            'news_content' => ['required']
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['author'] = Auth::user()->id;
        $post = Post::create($validatedData);

        return new PostDetailResource($post->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    public function update(Request $request, $id)
    {
         $validatedData = $request->validate([
            'title' => ['required','max:255'],
            'news_content' => ['required']
         ]);

         $post = Post::findOrFail($id);
         $post->update($request->all());
         return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete($id);

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
