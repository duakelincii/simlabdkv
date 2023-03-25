<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class Usercontroller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all();
            dd($users);
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user)
                {
                    $btn = "
                        <button class='btn btn-success btn-sm edit'>Edit</button>
                        <button class='btn btn-danger btn-sm delete'>Delete</button>
                    ";
                    return $btn;
                })
                ->make(true);
        }
        return view('user.index');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|string|max:255|unique:user,email,'.$user->id,
            'password' => 'required|string',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['msg' => 'Success Update Password']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['msg' => 'Success Delete member']);
    }

    // Get Member
    public function get(Request $request)
    {
        $name = $request->name;
        $member = User::where('name', 'like', '%'.$name.'%')->latest()->get(['id', 'name as text']);
        return $member;
    }
}
