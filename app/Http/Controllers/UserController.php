<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\File;
use App\MarkdownContent;
use App\Models\Information;

class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }

    public function getUsers()
    {

        $user = User::orderBy('id', 'desc')->get();
        return $user;
    }

    public function getProfile()
    {
        return view('profile');
    }

    public function createUsers(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'user_type' => 'required',
            'status' => 'required',
            'password' => 'required'

        ]);
        $user = new User();


        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function updateUsers(Request $request, $id)
    {
        $this->validate($request, [
            'name',
            'lastname',
            'email',
            'phone',
            'user_type',
            'status',
            'password'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);

        $user->save();
    }

    public function deleteUsers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
