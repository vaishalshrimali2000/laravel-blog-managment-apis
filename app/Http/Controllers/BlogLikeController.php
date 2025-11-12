<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogLikeController extends Controller
{
    //
    public function toggle(Request $request,Blog $blog){
        $userId = $request->user()->id;
        $existing = $blog->likes()->where('user_id',$userId)->first();

        if($existing){
            $existing->delete();
            $status = 'unliked';
        } else {
            $blog->likes()->create(['user_id' => $userId]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'likes_count' => $blog->likes()->count(),
        ]);
    }
}

