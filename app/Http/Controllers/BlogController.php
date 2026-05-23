<?php
namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()->paginate(9);
        $categories = Post::published()->whereNotNull("category")
            ->distinct()->pluck("category");
        return view("pages.blog.index", compact("posts","categories"));
    }

    public function show(string $slug)
    {
        $post = Post::where("slug",$slug)->where("status","published")->firstOrFail();
        $related = Post::published()->where("id","!=",$post->id)
            ->where("category",$post->category)->limit(3)->get();
        return view("pages.blog.show", compact("post","related"));
    }
}
