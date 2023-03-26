@extends('__layouts.app')

@section('title', 'Laporan')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="font-weight-bold text-primary m-0">Download Laporan</h6>
        </div>
        <div class="card-body">
            <form class="form-row" method="post" action="{{ route('laporan.download') }}">
                @csrf
                @method('post')
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Jenis Laporan</label>
                        <select class="form-control" name="jenis_laporan" id="" required>
                            <option value="LapBrgMsk">Laporan Barang Masuk</option>
                            <option value="LapBrgKlr">Laporan Barang Keluar</option>
                            <option value="LapPem">Laporan Peminjaman</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Mulai Dari</label>
                        <input type="date" class="form-control" name="date_mulai" placeholder="Mulai Dari">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Sampai Dengan</label>
                        <input type="date" class="form-control" name="date_sampai" placeholder="Sampai Dengan">
                    </div>
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" style="width: 20px;height: 20px;">
                            <path
                                d="M13.75 7h-3v5.296l1.943-2.048a.75.75 0 011.114 1.004l-3.25 3.5a.75.75 0 01-1.114 0l-3.25-3.5a.75.75 0 111.114-1.004l1.943 2.048V7h1.5V1.75a.75.75 0 00-1.5 0V7h-3A2.25 2.25 0 004 9.25v7.5A2.25 2.25 0 006.25 19h7.5A2.25 2.25 0 0016 16.75v-7.5A2.25 2.25 0 0013.75 7z" />
                        </svg>
                        Download</button>
                </div>
            </form>
        </div>
    </div>

@endsection
