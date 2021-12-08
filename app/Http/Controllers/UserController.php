<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $name = 'all';
        return view('dashboard.user.index', compact('users','name'));
    }

    public function guru()
    {
        $users = User::all()->where('role','guru');
        $name = 'Guru';
        return view('dashboard.user.index', compact('users','name'));
    }

    public function siswa()
    {
        $users = User::all()->where('role','siswa');
        $name = 'Siswa';
        return view('dashboard.user.index', compact('users','name'));
    }

    public function create($name)
    {
        return view('dashboard.user.create',compact('name'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'string',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'picture' => 'image|mimes:jpg,png,jpeg,svg|max:5000',
            'role' => 'required|in:admin,guru,siswa'
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $this->uploadFoto($request->file('picture'));
        }

        $validated['password'] = Hash::make($request->password);
        User::create($validated);

        Session::flash('success', 'Berhasil Menambahkan User');

        $prev = url()->previous();
        if ($prev==url('/').'/users/create/Siswa') {
            return redirect(route('user.siswa'));
        } else {
            return redirect(route('user.guru'));
        }


    }

    private function uploadFoto($image)
    {
        $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
        $path = 'uploads/avatar/';
        $targetPath = public_path('storage/');
        $fullPath = $path . $filename;
        $img = Image::make($image);
        $dimension = 512;
        $img->fit($dimension);
        $img->fit($dimension, $dimension, function ($constraint) {
            $constraint->upsize();
        });

        if (!Storage::has('public/' . $path))
            Storage::makeDirectory('public/' . $path);

        $img->save($targetPath . $fullPath);

        return $fullPath;
    }

    public function edit(User $user)
    {
        return view('dashboard.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|unique:users,username,' . $user->id,
            'password' => 'sometimes|nullable|min:6',
        ]);
        if (!$validated['password'] ?? '') {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('picture')) {
            $validated['picture'] = $this->uploadFoto($request->file('picture'));
            if ($user->picture) {
                //Delete Avatar
                $avaExists = $user->picture;
                Storage::disk('public')->delete($avaExists);
                $avaExists->delete();
            }
        }
        $user->update($validated);

        Session::flash('success', 'Berhasil Memperbaharui User');

        if ($user->role=='guru') {
            return redirect(route('user.guru'));
        } else {
            return redirect(route('user.siswa'));
        }

    }

    public function destroy(User $user)
    {
        Storage::disk('public')->delete($user['picture']);
        $user->delete();
        Session::flash('success', 'Berhasil Menghapus User');
        return redirect()->back();
    }

}
