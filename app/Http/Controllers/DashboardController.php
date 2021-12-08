<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (Auth::user()->role!='admin') {
            return redirect(route('classroom.index'));
        }

        $dashboard['classroom'] = Room::all()->count();
        $dashboard['course'] = Course::all()->count();
        $dashboard['lecturer'] = User::whereRole('guru')->get()->count();
        $dashboard['student'] = User::whereRole('siswa')->get()->count();

        return view('dashboard.index', compact('dashboard'));
    }
}
