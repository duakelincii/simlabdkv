<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;

class LaporanController extends Controller
{

    private $data;
    public function index()
    {
        return view('laporan.index');
    }

    public function download(Request $request)
    {
        $filename = '';
        $jenis = $request->jenis_laporan;
        if ($jenis == 'LapBrgMsk') {
            $barang = Stock::with('barang')->where('type', 'in')
                ->when($request->date_mulai, function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->date_mulai);
                })
                ->when($request->date_sampai, function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->date_mulai);
                })
                ->get();

            $this->data['barangs'] = $barang;
            $this->data['jenis'] = 'barang masuk';
            $this->data['judul'] = 'Laporan Barang Masuk';
            $filename = 'laporan barang masuk.pdf';
        } else if ($jenis == 'LapBrgKlr') {
            $barang = Stock::with('barang')->where('type', 'out')
                ->when($request->date_mulai, function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->date_mulai);
                })
                ->when($request->date_sampai, function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->date_mulai);
                })
                ->get();
            $this->data['barangs'] = $barang;
            $this->data['jenis'] = 'barang keluar';
            $this->data['judul'] = 'Laporan Barang Keluar';
            $filename = 'laporan barang keluar.pdf';
        } else if ($jenis == 'LapPem') {
            $loan = Loan::with(['barangs', 'member'])
                ->when($request->date_mulai, function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->date_mulai);
                })
                ->when($request->date_sampai, function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->date_mulai);
                })
                ->get();
            $this->data['loans'] = $loan;
            $this->data['jenis'] = 'peminjaman';
            $this->data['judul'] = 'Laporan Peminjaman';
            $filename = 'Laporan Peminjaman.pdf';
        }

        $view = view('laporan.download', $this->data);
        $html = $view->render();
        $pdf = new TCPDF;
        $pdf::SetTitle('Laporan');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path($filename), 'F');
        return response()->download(public_path($filename));
    }
}
