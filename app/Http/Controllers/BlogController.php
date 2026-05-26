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

        $hotIds = Cache::remember('blog_hot_ids', 3600, function () {
            return Post::published()->pluck('id')
                ->sortByDesc(fn($id) => Cache::get("post_views_{$id}", 0))
                ->take(3)->values()->toArray();
        });

        return view("pages.blog.index", compact("posts","categories","hotIds"));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("blog_post_{$slug}", 3600, function () use ($slug) {
            return Post::where("slug",$slug)->where("status","published")->firstOrFail();
        });

        Cache::increment("post_views_{$post->id}");
        Cache::forget('blog_hot_ids');

        $related = Cache::remember("blog_related_{$post->id}", 3600, function () use ($post) {
            $query = Post::published()->where("id","!=",$post->id);
            if ($post->category) {
                $query->where("category", $post->category);
            }
            return $query->limit(3)->get();
        });

        return view("pages.blog.show", compact("post","related"));
    }
}
