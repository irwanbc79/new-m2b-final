<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);

        $posts = Cache::remember("blog_index_{$page}", 3600, function () {
            return Post::published()->paginate(9);
        });

        $categories = Cache::remember('blog_categories', 3600, function () {
            return Post::published()->whereNotNull("category")
                ->distinct()->pluck("category");
        });

        return view("pages.blog.index", compact("posts","categories"));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("blog_post_{$slug}", 3600, function () use ($slug) {
            return Post::where("slug",$slug)->where("status","published")->firstOrFail();
        });

        $related = Cache::remember("blog_related_{$post->id}", 3600, function () use ($post) {
            return Post::published()->where("id","!=",$post->id)
                ->where("category",$post->category)->limit(3)->get();
        });

        return view("pages.blog.show", compact("post","related"));
    }
}
