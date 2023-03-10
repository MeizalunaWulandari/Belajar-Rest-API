<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PemilikPostingan
{
    
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        $post = Post::findOrFail($request->id);

        if ($post->author != $currentUser->id) {
            return response()->json(['message' => 'Data not found'], 404);
        } 
        return $next($request);
    }
}
