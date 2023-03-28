<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    // public function download(Request $request)
    // {
    //     $filename = '';
    //     $jenis = $request->jenis_laporan;
    //     if ($jenis == 'LapBrgMsk') {
    //         $barang = Stock::with('barang')->where('type', 'in')
    //             ->when($request->date_mulai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '>=', $request->date_mulai);
    //             })
    //             ->when($request->date_sampai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '<=', $request->date_mulai);
    //             })
    //             ->get();

    //         $this->data['barangs'] = $barang;
    //         $this->data['jenis'] = 'barang masuk';
    //         $this->data['judul'] = 'Laporan Barang Masuk';
    //         $filename = 'laporan barang masuk.pdf';
    //     } else if ($jenis == 'LapBrgKlr') {
    //         $barang = Stock::with('barang')->where('type', 'out')
    //             ->when($request->date_mulai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '>=', $request->date_mulai);
    //             })
    //             ->when($request->date_sampai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '<=', $request->date_mulai);
    //             })
    //             ->get();
    //         $this->data['barangs'] = $barang;
    //         $this->data['jenis'] = 'barang keluar';
    //         $this->data['judul'] = 'Laporan Barang Keluar';
    //         $filename = 'laporan barang keluar.pdf';
    //     } else if ($jenis == 'LapPem') {
    //         $loan = Loan::with(['barangs', 'member'])
    //             ->when($request->date_mulai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '>=', $request->date_mulai);
    //             })
    //             ->when($request->date_sampai, function ($q) use ($request) {
    //                 $q->whereDate('created_at', '<=', $request->date_mulai);
    //             })
    //             ->get();
    //         $this->data['loans'] = $loan;
    //         $this->data['jenis'] = 'peminjaman';
    //         $this->data['judul'] = 'Laporan Peminjaman';
    //         $filename = 'Laporan Peminjaman.pdf';
    //     }

    //     $view = view('laporan.download', $this->data);
    //     $html = $view->render();
    //     $pdf = new TCPDF;
    //     $pdf::SetTitle('Laporan');
    //     $pdf::AddPage();
    //     $pdf::writeHTML($html, true, false, true, false, '');
    //     $pdf::Output(public_path($filename), 'F');
    //     return response()->download(public_path($filename));
    // }

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


        $pdf = new TCPDF;
        $pdf::SetTItle($filename);
        $pdf::SetFont('times');
        $pdf::SetFontSize(12);
        $pdf::setMargins(20, 5, 20, 5);
        $pdf::AddPage('L', 'A4');
        $pdf::SetAutoPageBreak(TRUE, 0);

        $logo = public_path('images/logo.jpeg');
        $pdf::Image($logo, 65, 7, 23, 23, '', '', '', false, 300, '', false, false, 0);
        $tb = 0;
        $surat = '';
        $surat .= "<html><head></head><body><style>body {font-family: Times New Roman, Helvetica;} </style>";
        $surat .= '<div style="text-align:center; padding:0px; margin:0px;">';
        $surat .= '<p style="line-height: 0px; font-size: 14px; color:black; font-weight:bold;">PEMERINTAH PROVINSI SULAWESI SELATAN</p>';
        $surat .= '<p style="line-height: 0px; font-size: 14px; color:black; font-weight:bold;">CABANG DINAS PENDIDIKAN WILAYAH VIII</p>';
        $surat .= '<p style="line-height: 0px; font-size: 14px; color:black; font-weight:bold;">UPT SMKN 4 PINRANG</p>';
        $tb += 3.5;
        $surat .= '<p style="line-height: 0px; font-size: 10px; color:black; font-weight:bold;">Jalan.Poros Benteng – Maccobbu, E-mail: smkn4.prg@gmail.com</p>';
        $tb += 2;
        $surat .= "</div>";
        $pdf::writeHTML($surat, true, false, true, false, '');
        $ln1 = 31 + $tb;
        $ln2 = 31.5 + $tb;
        $ln3 = 31.6 + $tb;
        $ln4 = 31.7 + $tb;
        $ln5 = 31.8 + $tb;
        $pdf::Line(20, $ln1, 280, $ln1);
        $pdf::Line(20, $ln2, 280, $ln2);
        $pdf::Line(20, $ln3, 280, $ln3);
        $pdf::Line(20, $ln4, 280, $ln4);
        $pdf::Line(20, $ln5, 280, $ln5);
        $pdf::ln(5);
        $nomor = '<p style="line-height: 0px;font-weight:bold;text-align:center;font-size:14px;margin-top:100px">Daftar ' . $this->data['jenis'] . '</p>';
        $pdf::ln(10);
        $view = view('laporan.download', $this->data);
        $pdf::writeHTML($view, true, false, true, false, '');

        // $pdf::ln(5);
        $pejabat = '<table border="0" cellpadding="0" cellspacing="0">';
        $pejabat .= '<tr><td width="550"></td><td width="220">Pimrang ,' . Carbon::parse(now())->isoFormat('D MMMM Y') . '</td></tr>';
        $pejabat .= '<tr><td width="550"></td><td width="220">Kepala Laboratorium DKV</td></tr>';
        $pejabat .= '</table>';
        $pdf::writeHTML($pejabat, true, false, true, false, '');
        $pdf::ln(15);
        $nmpejabat = '<table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="550"></td><td width="220" style="text-decoration:underline;">Andi Ahmad Afandi, S.Kom, Gr</td>
                </tr>
                <tr>
                    <td width="550"></td><td width="220">NI PPPK. 198011092022211013</td>
                </tr></table>';
        $pdf::writeHTML($nmpejabat, true, false, true, false, '');
        $pdf::Output(public_path($filename), 'F');
        return response()->download(public_path($filename));
    }
}
