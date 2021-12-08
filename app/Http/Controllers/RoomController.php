<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Room::all();
        return view('dashboard.class.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);

        Room::create($validated);

        return back()->with('success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $room->load('students');
        $classrooms = Classroom::all()->where('room_id', $room->id);
        $siswa = ClassStudent::all()->where('room_id',$room->id);
        return view('dashboard.class.show', compact('room','classrooms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Room::find($room->id)->update($request->all());
        return back()->with('success','Kelas '.$room->name.' berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        Room::destroy($room->id);
        return back()->with('success','Kelas '.$room->name.' berhasil dihapus');
    }

    public function dropSiswa(Request $request)
    {
        $room_id = $request->room_id;
        $user_id = $request->user_id;
        $name = $request->name;
        ClassStudent::where('room_id',$room_id)->where('user_id',$user_id)->delete();
        return back()->with('success','Siswa '.$name.' berhasil dihapus');
    }
}
