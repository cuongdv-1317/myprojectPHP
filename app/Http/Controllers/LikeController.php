<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserLikesPost;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, User $user, Post $post)
    {
        $like = new UserLikesPost();
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        $like->save();
    }

    public function unlike(Request $request, User $user, Post $post)
    {
        $like = UserLikesPost::where('user_id', $user->id)->where('post_id', $post->id)->delete();
        // return response()->json(['like' => $like], 200);
        // $like->delete();
    }
}
