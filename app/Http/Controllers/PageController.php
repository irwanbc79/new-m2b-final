<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TeamMember;

class PageController extends Controller
{
    public function home()
    {
        $latestPosts = Post::published()->limit(3)->get();
        return view("pages.home", compact("latestPosts"));
    }

    public function about()
    {
        return view("pages.about");
    }

    public function tim()
    {
        $members = TeamMember::active()->get();
        return view("pages.tim", compact("members"));
    }

    public function privacy()
    {
        return view("pages.legal", [
            "title" => "Privacy Policy / Kebijakan Privasi",
            "slug" => "privacy-policy",
        ]);
    }

    public function disclaimer()
    {
        return view("pages.legal", [
            "title" => "Disclaimer / Penafian",
            "slug" => "disclaimer",
        ]);
    }

    public function terms()
    {
        return view("pages.legal", [
            "title" => "Ketentuan Layanan",
            "slug" => "terms",
        ]);
    }
}
