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
            $users = User::query();
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    $btn = '
                        <button class="btn btn-success btn-sm edit" title="edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm delete" title="hapus"><i class="fas fa-trash"></i></button>
                    ';
                    return $btn;
                })
                ->toJson();
        }
        return view('user.index');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            // 'email' => 'required|string|max:255|unique:user,email,' . $user->id,
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['msg' => 'Berhasil Update Password']);
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

        return response()->json(['msg' => 'Berhasil Delete member']);
    }

    // Get Member
    public function get(Request $request)
    {
        $name = $request->name;
        $member = User::where('name', 'like', '%' . $name . '%')->latest()->get(['id', 'name as text']);
        return $member;
    }

}
