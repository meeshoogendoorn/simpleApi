<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(User $model)
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "no permission");

        $users = User::all();

        return view('users.index', compact("users"));
    }

    public function create()
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "no permission");

        return view("auth.register");
    }

    public function store(UserRequest $request)
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "no permission");

        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        $user->save();

        return redirect()->route("users.index")->with("success", "Successfully registered new user");
    }

    public function destroy($user_id)
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "no permission");

        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->back()->with("success", "Successfully deleted user");
    }
}
