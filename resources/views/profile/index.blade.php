@extends('__layouts.app')

@section('title', 'Profile')

@section('content')


<div class="col-md-6 mx-auto">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="font-weight-bold text-primary m-0">Edit Profile</h6>
        </div>
        <div class="card-body">
            <form action="{{route('profile.save')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="member_id" value="{{old('member_id',$item->member_id ?? '')}}">
                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" placeholder="ID KTP" value="{{ old('nik',$item->member->nik) }}" required>

                            @error('nik')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Lengkap" value="{{ old('name', $item->member->name ?? '') }}">

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>No Telpon</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="No Telpon" value="{{ old('phone', $item->member->phone ?? '') }}">

                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control custom-select @error('gender') is-invalid @enderror">
                                <option value="Laki - Laki" {{ 'Laki - Laki' == old('Laki - Laki', $item->member->gender ?? '') ? 'selected' : '' }}>Laki - Laki</option>
                                <option value="Perempuan" {{ 'Perempuan' == old('Perempuan', $item->member->gender ?? '') ? 'selected' : '' }}>Perempuan</option>
                            </select>

                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" placeholder="birthday" value="{{ old('birthday', $item->member->birthday ?? '') }}">

                            @error('birthday')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Alamat">{{ old('address',$item->member->address ?? '') }}</textarea>

                    @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Unggah Gambar</label>
                    <div class="custom-file">
                        <label class="custom-file-label">{{ old('file', $item->member->photo ?? 'Unggah Gambar') }}</label>
                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file" placeholder="Unggah Gambar"  value="{{ old('file', $item->member->photo ?? '') }}">

                        @error('file')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <hr>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email',$item->email ?? '') }}" placeholder="Email" autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                      <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password" name="password" autocomplete="new-password">
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                  <input type="password" class="form-control form-control-user" placeholder="Repeat Password" name="password_confirmation" autocomplete="new-password">
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
