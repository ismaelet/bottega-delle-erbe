<?php

namespace App\Http\Controllers;

use App\Services\PublicNavigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(PublicNavigation $navigation): View
    {
        return view('blog.index', [
            'posts' => DB::table('posts')->orderByDesc('time')->paginate(12),
            'menus' => $navigation->menus(),
        ]);
    }

    public function show(Request $request, PublicNavigation $navigation): View|RedirectResponse
    {
        $id = $request->query('id');

        if (! is_string($id) || ! ctype_digit($id)) {
            return redirect('/blog');
        }

        $post = DB::table('posts')->where('id', $id)->first();

        if (! $post) {
            return redirect('/blog');
        }

        return view('blog.show', [
            'post' => $post,
            'morePosts' => DB::table('posts')->where('id', '<>', $id)->orderByDesc('time')->limit(3)->get(),
            'menus' => $navigation->menus(),
        ]);
    }
}
