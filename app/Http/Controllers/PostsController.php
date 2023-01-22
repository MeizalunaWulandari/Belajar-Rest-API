<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        // $data = [
        //     'message' => 'success',
        //     'data' => $posts
        // ];
        // return response()->json($data, response::HTTP_OK);

        return PostDetailResource::collection($posts->loadMissing('writer:id,username'));

    }

    public function show($id)
    {
        // NOTE : findOrFail harus diakhir
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
        // return response()->json($post, response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'max:200'],
            'news_content' => ['required']
        ]);
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete($id);

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
