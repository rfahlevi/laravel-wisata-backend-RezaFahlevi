<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);

        if($request->has('user_search')){
            $users = User::where('name', 'like', '%' . $request->user_search . '%')
                    ->orWhere('email', 'like', '%' . $request->user_search . '%')
                    ->orWhere('phone', 'like', '%' . $request->user_search . '%')
                    ->paginate(10);
         }

        $data = [];
        $data['type_menu'] = 'users';
        $data['users'] = $users;
        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.add', [
            'type_menu' => 'users'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        
        $newUser = new User();
        $newUser->name = $data['name'];
        $newUser->slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));
        $newUser->email = $data['email'];
        $newUser->password = Hash::make($data['password']);
        $newUser->phone = $data['phone'];
        $newUser->role = $data['role'];
        $newUser->save();

        return redirect()->route('users.index')->with('success', 'Berhasil menambahkan user baru');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $data = [];
        $data['type_menu'] = 'users';
        $data['user'] = $user;
        return view('pages.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $slug)
    {
        $data = $request->validated();

        $user = User::where('slug', $slug)->firstOrFail();
        $user->name = $data['name'];
        $user->slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(10));
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->role = $data['role'];
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'Berhasil mengupdate : ' . $user->name);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $user = User::findOrFail($slug);
        $user->delete();

        return redirect()->route('users.index')->with('success', "Berhasil menghapus user $user->name");
    }
}
