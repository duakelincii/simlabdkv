@extends('__layouts.app')

@section('title', 'Stock Keluar')

@section('content')

	<div class="row">
		<div class="col-md-4">
			<div class="card shadow mb-4">
			<form action="" id="create">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Stock Keluar</h6>
				</div>
				<div class="card-body">
					@csrf
					<input type="hidden" name="type" value="out">
					<div class="form-group">
						<label>Kode</label>
						<select name="code" class="form-control custom-select" placeholder="Kode" required></select>
					</div>
					<div class="form-group">
						<label>Keluar Barang</label>
						<input type="text" class="form-control" name="from" placeholder="Keluar Barang" required>
					</div>
					<div class="form-group">
						<label>Total</label>
						<input type="number" class="form-control" name="total" placeholder="Total" required>
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="primary">Simpan</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-8">
			<div class="card shadow">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Riwayat Stock Keluar</h6>
				</div>
				<div class="card-body">
					<div id="alert"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode</th>
                                    <th>Keluar Barang</th>
									<th>Total</th>
									<th>Tanggal</th>
                                    <th>Ket</th>
									<th>Aksi</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('stock.remove') }}"
		let createUrl = "{{ route('stock.create') }}"
		let deleteUrl = "{{ route('stock.destroy', ':id') }}"
		let getBookUrl = "{{ route('barang.get') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/select2/js/select2.min.js') }}"></script>

	<script src="{{ asset('js/stock.js') }}"></script>

	<script>
		$('[name=code]').on('select2:select', function (e) {
			let stock = e.params.data.stock
			let total = $('[name=total]')
			let max = $('.max')

			total.attr('max', stock)
			max.html(`Stock ${stock}`)
		})
	</script>

@endpush
