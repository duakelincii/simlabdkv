<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }

        return view('loan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // $request->validate([
            //     'member_id' => 'required|exists:members,id',
            //     'return' => 'required|date|after:today',
            //     'barang_id' => 'required|array',
            //     'total_id' => 'required|array',
            // ]);

            $qty = collect($request->total_id);
            $barangs = collect($request->barang_id);
            $qty = $qty->map(function ($item) {
                return ['qty' => $item];
            });
            $barangs = $barangs->combine($qty);
            $barangs->each(function ($item, $key) {
                $barang = Barang::findOrFail($key);
                $barang->decrement('stock', $item['qty']);
            });
            DB::commit();
            $loan = Loan::create($request->only('member_id', 'return'));
            $loan->barangs()->attach($barangs->all());

            return redirect(route('loan.index'))->with('success', 'Success Make Loan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response()->json(['msg' => 'Success Delete Loan']);
    }

    // Return Loan
    public function return(Loan $loan)
    {
        $barangs = $loan->barangs;

        $barangs->each(function ($barang) {
            $barang->increment('stock', $barang->pivot->qty);
        });

        $loan->update([
            'status' => 0
        ]);

        return response()->json(['msg' => 'Success Return Loan']);
    }

    // Extend Loan
    public function extend(Request $request, Loan $loan)
    {
        $request->validate([
            'date' => 'required|date|after:today'
        ]);

        $loan->update([
            'return' => $request->date
        ]);

        return response()->json(['msg' => 'Success Extend Loan']);
    }

    // Get Datatatble
    public function datatable()
    {
        if (Auth::user()->is_admin == 1) {
            $loans = Loan::with(['barangs' => function ($barang) {
                $barang->select('name');
            }, 'member' => function ($member) {
                $member->select('id', 'name');
            }])->latest()->get();
        } else {
            $loans = Loan::with(['barangs' => function ($barang) {
                $barang->select('name');
            }, 'member' => function ($member) {
                $member->select('id', 'name', 'user_id');
            }])->whereHas('member', function ($q) {
                $q->where('id', Auth::user()->member->id);
            })->orderby('loans.created_at', 'desc')->get();
        }
        return Datatables::of($loans)
            ->addIndexColumn()
            ->addColumn('late', function ($loan) {
                if ($loan->status) {
                    $today = Carbon::today();
                    $return = Carbon::parse($loan->return);
                    // dd($today->diffInDays($return, true), 0);
                    return $today->diffInDays($return, true);
                } else {
                    return 0;
                }
            })
            ->addColumn('return_date', function ($loan) {
                return $loan->return;
            })
            ->editColumn('return', '{{ localDate($return) }}')
            ->make(true);
    }
}
