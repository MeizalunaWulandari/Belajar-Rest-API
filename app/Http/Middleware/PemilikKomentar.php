<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PemilikKomentar
{
    
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        $comment = Comment::findOrFail($request->id);

        if ($comment->user_id != $currentUser->id) {
            return response()->json(['message' => 'Data not found'], 404);
        } 
        return $next($request);
    }
}
