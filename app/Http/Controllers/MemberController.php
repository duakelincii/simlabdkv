<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = Member::all();

            return Datatables::of($members)
                ->addIndexColumn()
                ->addColumn('action', function ($member)
                {
                    $btn = "
                        <a class='btn btn-info btn-sm' href=".route('member.show', $member->id)." title='Lihat'><i class='fas fa-eye'></i></a>
                        <button class='btn btn-success btn-sm edit' title='Edit'><i class='fas fa-edit'></i></button>
                        <button class='btn btn-danger btn-sm delete' title='Hapus'><i class='fas fa-edit'></i></button>
                    ";
                    return $btn;
                })
                ->make(true);
        }
        return view('member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:members',
            'phone' => 'required|numeric|digits_between:1,15',
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'address' => 'required|string',
            'file' => 'required|image',
            'nik' => 'required'
        ]);

        $file = $request->file;
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = time().'.'.$file->getClientOriginalExtension();

        $request->file->storeAs('public/images', $fileName);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
            'is_admin'  => 0,
        ]);

        $request->merge([
            'photo' => $fileName,
            'user_id' => $user->id,
        ]);
        Member::create($request->all());
        return redirect('member')->with('success', 'Success Add Member');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:members,name,'.$member->id,
            'phone' => 'required|numeric|digits_between:1,15',
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'address' => 'required|string',
            'file' => 'image|nullable',
            'nik' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file;
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = time().'.'.$file->getClientOriginalExtension();

            $request->file->storeAs('public/images', $fileName);

            $request->merge([
                'photo' => $fileName
            ]);
        }
        $user = User::where('member_id',$member)->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
            'is_admin'  => 0,
        ]);
        $member->update($request->all());

        return response()->json(['msg' => 'Success Update member']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json(['msg' => 'Success Delete member']);
    }

    // Get Member
    public function get(Request $request)
    {
        $name = $request->name;
        $member = Member::where('name', 'like', '%'.$name.'%')->latest()->get(['id', 'name as text']);
        return $member;
    }
}
