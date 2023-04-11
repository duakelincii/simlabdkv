<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $item = User::findOrFail(Auth::user()->id);
        return view('profile.index',compact('item'));
    }

	public function save(Request $request)
	{
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric|digits_between:1,15',
            'gender' => 'nullable|string',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'file' => 'nullable|image',
            'password' => 'required|string|min:8|confirmed',
        ]);

		if ($request->filled('password')) {
			$password = Hash::make($request->password);

			$request->merge(['password' => $password]);

			$data = $request->except('_token','_method');
		} else {
			$data = $request->only('name', 'email');
		}
		Auth::user()->update($data);
		return back()->with('success', 'Success Update Profile');
	}

}
