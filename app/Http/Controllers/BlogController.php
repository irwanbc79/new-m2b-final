<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $category = request()->get('category');
        $page     = request()->get('page', 1);
        $cacheKey = 'blog_index_' . $page . ($category ? '_' . Str::slug($category) : '');

        $posts = Cache::remember($cacheKey, 3600, function () use ($category) {
            $query = Post::published()->latest('published_at');
            if ($category) {
                $query->where('category', $category);
            }
            return $query->paginate(9);
        });

        $categories = collect(Post::CATEGORIES);

        $hotIds = Cache::remember('blog_hot_ids', 3600, function () {
            return Post::published()->pluck('id')
                ->sortByDesc(fn($id) => Cache::get("post_views_{$id}", 0))
                ->take(3)->values()->toArray();
        });

        $featured = Cache::remember('blog_featured_post', 3600, function () {
            return Post::published()->latest('published_at')->first();
        });

        $popular = Cache::remember('blog_popular_posts', 3600, function () use ($hotIds) {
            $pop = Post::published()->whereIn('id', $hotIds)->get()
                       ->sortByDesc(fn($p) => Cache::get("post_views_{$p->id}", 0))
                       ->values();
            if ($pop->isEmpty()) {
                return Post::published()->latest('published_at')->take(4)->get();
            }
            return $pop;
        });

        return view("pages.blog.index", compact("posts", "categories", "hotIds", "category", "featured", "popular"));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("blog_post_{$slug}", 3600, function () use ($slug) {
            return Post::where("slug",$slug)->where("status","published")->firstOrFail();
        });

        Cache::increment("post_views_{$post->id}");
        // Note: blog_hot_ids is intentionally NOT forgotten here. View counts change on
        // every show(); forgetting on each one defeated the 1h TTL and forced a DB
        // recompute on the next index load. The hot list now refreshes at most hourly
        // (and immediately when a post is saved/deleted via Post model hooks).

        $related = Cache::remember("blog_related_{$post->id}", 3600, function () use ($post) {
            $query = Post::published()->where("id","!=",$post->id);
            if ($post->category) {
                $query->where("category", $post->category);
            }
            return $query->limit(3)->get();
        });

        return view("pages.blog.show", compact("post","related"));
    }

    public function feed()
    {
        $posts = Cache::remember('blog_feed', 3600, function () {
            return Post::published()->take(20)->get();
        });

        return response()
            ->view('pages.blog.feed', compact('posts'))
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}
