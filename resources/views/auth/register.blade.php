@extends('__layouts.auth')

@section('title', 'Register')

@section('content')
<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
  <div class="col-lg-12">
    <div class="p-12">
      <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru</h1>
      </div>
      <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
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
            <label>Unggah Gambar</label>
            <div class="custom-file">
                <label class="custom-file-label">Unggah Gambar</label>
                <input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file" placeholder="Photo" accept="image/png, image/jpg, image/jpeg"value="{{ old('file') }}">

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
            <label>Confirm Password</label>
          <input type="password" class="form-control form-control-user" placeholder="Repeat Password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Simpan</button>
            <a href="{{ route('login') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
    </div>
  </div>
</div>

@endsection
