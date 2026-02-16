<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $posts = Post::where('is_published', true)->latest()->get();
        $categories = Category::all();

        return response()->view('sitemap', [
            'posts' => $posts,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
