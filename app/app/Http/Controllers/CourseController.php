<?php

namespace App\Http\Controllers;

use App\Services\PublicNavigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(PublicNavigation $navigation): View
    {
        return view('courses.index', [
            'courses' => DB::table('courses')->orderByDesc('id')->paginate(5),
            'menus' => $navigation->menus(),
        ]);
    }

    public function show(Request $request, PublicNavigation $navigation): View|RedirectResponse
    {
        $id = $request->query('id');

        if (! is_string($id) || ! ctype_digit($id)) {
            return redirect('/courses');
        }

        $course = DB::table('courses')->where('id', $id)->first();

        if (! $course) {
            return redirect('/courses');
        }

        return view('courses.show', [
            'course' => $course,
            'moreCourses' => DB::table('courses')->where('id', '<>', $id)->orderByDesc('id')->limit(4)->get(),
            'menus' => $navigation->menus(),
        ]);
    }
}
