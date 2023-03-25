<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Yajra\Datatables\Datatables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }
        return view('barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang.create');
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
            'code' => 'string|max:6|unique:barangs|nullable',
            'name' => 'required|string|max:255|unique:barangs',
            'satuan' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        Barang::create($request->all());

        return redirect('barang')->with('success', 'Success Create barang');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'code' => 'string|max:6|nullable|unique:barangs,code,'.$barang->id,
            'name' => 'required|string|max:255|unique:barangs,name,'.$barang->id,
            'satuan' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        $barang->update($request->all());

        return response()->json(['msg' => 'Success Update barang']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->json(['msg' => 'Success Delete barang']);
    }

    // Get barang
    public function get(Request $request)
    {
        $code = $request->code;
        $barangs = Barang::where('code', 'like', '%'.$code.'%')->latest()->get(
            ['id', 'code as text', 'name', 'stock']
        );
        return $barangs;
    }

    // Get Datatable
    public function datatable()
    {
        $barangs = Barang::with('category')->get();
        return Datatables::of($barangs)
                    ->addIndexColumn()
                    ->addColumn('action', function ()
                    {
                        $btn = '
                            <button class="btn btn-success btn-sm edit">Edit</button>
                            <button class="btn btn-danger btn-sm delete">Delete</button>
                        ';
                        return $btn;
                    })
                    ->make(true);
    }
}
