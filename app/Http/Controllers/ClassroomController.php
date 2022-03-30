<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\QuizResult;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shivella\Bitly\Facade\Bitly;

class ClassroomController extends Controller
{
    public function index()
    {
        $user = User::whereId(Auth::user()->id)->first();
        if ($user['role'] == 'admin') {
            return redirect()->route('dashboard');
            $classrooms = Classroom::with('students')->orderBy('id')->paginate(12);
        } elseif ($user['role'] == 'guru') {
            $classrooms = Classroom::all()->where('user_id', Auth::user()->id);
            $room = true;
        } else {
            $room = ClassStudent::where('user_id',$user->id)->first();
            $classrooms = Classroom::all()->where('room_id',$room->room_id);
            // $classrooms = Classroom::whereHas('students', function ($q) use ($user) {
            //     $q->where('user_id', $user['id']);
            // })->paginate(12);

        }
        return view('dashboard.classroom.index', compact('classrooms','room'));
    }

    public function create(Room $room)
    {
        $user = User::all()->where('role','guru');
        return view('dashboard.classroom.create', compact('user','room'));
    }

    public function edit(Classroom $classroom)
    {
        $user = User::all()->where('role','guru');
        return view('dashboard.classroom.edit', compact('classroom','user'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:191',
            'description' => 'required',
            'enroll_code' => 'sometimes|nullable|string',
            'user_id' => 'required',
            'room_id' => 'required',
        ]);

        // $validated['id'] = Str::orderedUuid()->getHex();
        $room = Room::find($request->room_id);
        $validated['id'] = $request->enroll_code.'-'.str_replace(' ', '-', $room->name);
        Classroom::create($validated);

        return redirect()->route('room.show',['room'=>$request->room_id])->with(['success' => 'Berhasil Membuat Kelas']);
    }

    public function show(Classroom $classroom)
    {

        if (\auth()->user()->role == 'siswa') {
            $class = ClassStudent::where('user_id', \auth()->id())->where('room_id', $classroom['room_id'])->first();

            if (!$class) {
                return redirect()->route('classroom.index');
            }
        }


        $classroom->load('course.files');
        $classroom->load(['students', 'quizzes']);

        if (Auth::user()->role=='guru') {
            $data_quiz = $classroom['quizzes'];
        } else {
            $data_quiz = QuizResult::join('quizzes','quizzes.id','=','quiz_results.quiz_id')
                            ->where('quiz_results.user_id',Auth::id())
                            ->where('quizzes.classroom_id',$classroom->id)
                            ->select('quiz_results.status','quiz_results.score','quizzes.*')
                            ->get();
        }

        $url = null;
        $room = Room::find($classroom->room_id);
        // if ($classroom['enroll_code']) {
        //     $url = Bitly::getUrl(route('enroll.view', $classroom));
        // }
        return view('dashboard.classroom.show', compact('classroom', 'url','room','data_quiz'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:191',
            'description' => 'required',
            'user_id' => 'required'
        ]);

        $classroom->update($validated);

        return redirect()->route('room.show',['room'=>$classroom->room_id])->with(['success' => 'Berhasil Memperbaharui Kelas']);
    }

    public function showStudents(Classroom $classroom)
    {
        $absensi = Attendance::all()->where('classroom_id',$classroom->id)->groupBy('date');
        return view('dashboard.classroom.student', compact('absensi','classroom'));
    }

    public function showQuizResult(Classroom $classroom)
    {
        $classroom->load('quizzes.result.student');

        return view('dashboard.classroom.quiz_result', compact('classroom'));
    }

    public function invite(Request $request)
    {
        $validated = $this->validate($request, [
            'room_id' => 'required|exists:rooms,id',
            'students.*' => 'required|exists:users,id'
        ]);

        try {
            $classroom = Room::whereId($validated['room_id'])->first();

            $classroom->students()->attach($validated['students']);
        } catch (QueryException $e) {
            return back()->with(['error' => 'Siswa sudah diinvite']);
        }

        return back()->with(['success' => 'Berhasil Mengundang Siswa']);


    }

    public function deleteStudent($classroomId, $studentId)
    {
        $classroom = Classroom::whereId($classroomId)->first();
        $classroom->students()->detach($studentId);

        Session::flash('success', 'Berhasil Menghapus siswa dari Kelas');

        return url()->previous();
    }

    public function destroy(Classroom $classroom)
    {

        $courses = $classroom->course;
        if ($courses) {
            foreach ($courses as $course) {
                $files = $course->files()->get();

                foreach ($files as $file) {
                    Storage::delete($file['path'] . $file['filename']);
                }
            }
        }

        $classroom->delete();

        Session::flash('success', 'Berhasil Menghapus Mata Pelajaran');

        return back();
    }

    public function enrollView(Classroom $classroom)
    {
        abort_unless(\auth()->user()->role == 'siswa',403);

        $class = ClassStudent::where('user_id', \auth()->id())->where('classroom_id', $classroom['id'])->first();

        if ($class) {
            return redirect()->route('classroom.show', $classroom);
        }

        return view('dashboard.classroom.enroll', compact('classroom'));
    }

    public function enroll(Request $request, Classroom $classroom)
    {
        $this->validate($request, [
            'enroll_code' => 'required'
        ]);

        abort_unless(\auth()->user()->role == 'siswa',403);

        $class = ClassStudent::where('user_id', \auth()->id())->where('classroom_id', $classroom['id'])->first();
        if ($class) {
            return redirect()->route('classroom.show', $classroom);
        }

        if ($classroom['enroll_code']) {
            if ($request->get('enroll_code') !== $classroom['enroll_code']) {
                Session::flash('error', 'Enroll Code Salah');
            } else {
                $classroom->students()->attach(\auth()->id());
                Session::flash('success', 'Berhasil Bergabung Kelas');

                return redirect()->route('classroom.show', $classroom);
            }
        }else {
            Session::flash('error', 'Kelas ini tidak mengaktifkan enroll code');
        }

        return redirect()->back();
    }

    public function absensi(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);

        $index = count($request->user_id);
        $date = Carbon::parse($request->date);
        for ($i=0; $i < $index; $i++) {
            Attendance::create([
                'date' => $date,
                'classroom_id' => $request->classroom_id,
                'user_id' => $request->user_id[$i],
                'information' => $request->information[$i],
            ]);
        }
        Session::forget('showModel');
        Session::flash('success', 'Absensi ditambahkan!');
        return redirect()->back();
    }

    public function absensiShow(Classroom $classroom, $date)
    {
        $data = Attendance::all()->where('classroom_id',$classroom->id)->where('date',$date);
        return view('dashboard.classroom.absensi',compact('data','classroom','date'));
    }

    public function absensiUpdate(Attendance $attendance, Request $request)
    {
        Attendance::find($attendance->id)->update($request->all());
        Session::flash('success', 'Absensi berhasil diubah!');
        return redirect()->back();
    }

}
