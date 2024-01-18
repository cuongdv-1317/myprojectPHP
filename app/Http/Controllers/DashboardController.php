<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return view('dashboard', compact('posts'));
    }
}
