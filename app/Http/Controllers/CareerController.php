<?php
namespace App\Http\Controllers;

use App\Models\Career;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::open()->get();
        return view("pages.karir.index", compact("careers"));
    }

    public function show(int $id)
    {
        $career = Career::where("id",$id)->where("status","open")->firstOrFail();
        return view("pages.karir.show", compact("career"));
    }
}
