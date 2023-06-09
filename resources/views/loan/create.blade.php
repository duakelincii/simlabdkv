@extends('__layouts.app')

@section('title', 'Buat Pinjaman')

@section('content')

	<div class="row">

		<div class="col-md-4">
			<div class="card shadow mb-4">
			<form id="make">
				<div class="card-header">
					<h6 class="font-weight-bold text-primary m-0">Buat Pinjaman</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Kode Barang</label>
						<select name="code" class="form-control custom-select"></select>
					</div>
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name"disabled>
					</div>
					<div class="form-group">
						<label>Total</label>
						<input type="number" class="form-control" name="total" placeholder="Total" required>

						<small class="form-text text-muted"></small>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="submit">Tambah</button>
				</div>
			</form>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card shadow mb-4">
				<div class="card-header">
					<h6 class="font-weight-bold text-primary m-0">Data Pinjaman</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr id="empty">
									<td colspan="3" align="center">Kosong</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" data-toggle="modal" data-target="#save" id="saveBtn" disabled>Buat Pinjaman</button>
					<a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
				</div>
			</div>
		</div>

	</div>

	<div class="modal" id="save">
	<div class="modal-dialog">
	<div class="modal-content">
	<form action="{{ route('loan.store') }}" method="post">
		<div class="modal-header">
			<h5 class="modal-title">Buat Pinjaman</h5>
			<button class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			@csrf
			<div class="form-group">
				<label>Member</label>
				<select name="member_id" class="form-control custom-select" required></select>
			</div>
			<div class="form-group">
				<label>Tanggal Pinjam</label>
				<input type="date" class="form-control" name="tgl_pinjam" placeholder="Tangal Pinjam" min="{{ date('Y-m-d') }}">
			</div>
			<div class="form-group">
				<label>Tanggal Pengembalian</label>
				<input type="date" class="form-control" name="return" placeholder="Tanggal Pengembalian" min="{{ date('Y-m-d') }}">
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" type="submit">Simpan</button>
			<button class="btn btn-danger" data-dismiss="modal">Batal</button>
		</div>
	</form>
	</div>
	</div>
	</div>


@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script src="{{ asset('sbadmin/vendor/select2/js/select2.min.js') }}"></script>

	<script>
		let getBookUrl = '{{ route("barang.get") }}'
		let getMemberUrl = '{{ route("member.get") }}'
		let token = '{{ csrf_token() }}'
	</script>

	<script src="{{ asset('js/make_loan.js') }}"></script>

@endpush
