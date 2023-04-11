@extends('__layouts.app')

@section('title', 'User')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="font-weight-bold text-primary m-0">Data User</h6>
        </div>
        <div class="card-body">
            <div id="alert">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('success') }}
                        <button class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Email" required
                                        autocomplete="email" autofocus readonly>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ulangi Password</label>
                                    <input type="password" class="form-control form-control-user"
                                        placeholder="Ulangi Password" name="password_confirmation" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <button class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script>
        let ajaxUrl = "{{ route('user.index') }}"
        let updateUrl = "{{ route('user.update', ':id') }}"
        let deleteUrl = "{{ route('user.destroy', ':id') }}"
        let csrf = "{{ csrf_token() }}"
    </script>

    <script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script src="{{ asset('js/user.js') }}"></script>
@endpush
