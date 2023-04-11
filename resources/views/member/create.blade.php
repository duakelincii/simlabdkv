@extends('__layouts.app')

@section('title', 'Tambah Member')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Tambah Member</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>NIK</label>
								<input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" placeholder="ID KTP" value="{{ old('nik') }}" required>

								@error('nik')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>

								@error('name')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>No Telpon</label>
								<input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="No Telpon" value="{{ old('phone') }}" required>

								@error('phone')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="gender" class="form-control custom-select @error('gender') is-invalid @enderror" required>
									<option value="Laki - Laki">Laki - Laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>

								@error('gender')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" placeholder="birthday" value="{{ old('birthday') }}" required>

								@error('birthday')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Alamat" required>{{ old('address') }}</textarea>

						@error('address')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>

					<div class="form-group">
						<label>Gambar</label>
						<div class="custom-file">
							<label class="custom-file-label">Unggah Gambar</label>
							<input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file" placeholder="Photo" value="{{ old('file') }}" required>

							@error('file')
								<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

					</div>

                    <hr>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                          <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="new-password">
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                    </div>
                    <div class="form-group">
                        <label>Ulangi Password</label>
                      <input type="password" class="form-control form-control-user" placeholder="Ulangi Password" name="password_confirmation" required autocomplete="new-password">
                    </div>

					<div class="form-group">
						<button class="btn btn-primary" type="submit">Simpan</button>
						<a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('scripts')

	<script src="{{ asset('sbadmin/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

	<script>
		bsCustomFileInput.init()
	</script>

@endpush
