@extends('layouts.app')
@section('title','Create User - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Tambah {{ $name }} Baru</h6>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="role" value="{{ $name=="Guru"?'guru':'siswa' }}">
                            <div class="form-group">
                                <label for="name">Nama {{ $name }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="username">{{ $name=='Guru'?'NIP':'NIS' }}</label>
                                <input type="text" name="username" id="username" class="form-control"
                                       value="{{ old('username') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email') }}" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="image">Foto Profile (Opsional)</label>
                                <div class="custom-file text-left">
                                    <input type="file" name="picture" accept="image/*" class="custom-file-input"
                                           id="file"
                                           value="{{ old('picture') }}">
                                    <label class="custom-file-label" for="file">Pilih Foto Profile</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <a href="{{ $name=='Guru'?route('user.guru'):route('user.siswa') }}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        @if(Session::has('success'))
        swal("Berhasil !", '{{ Session::get('success') }}', "success");
        @endif
        $(function(){
            $('#username').keyup(function (e) {
                var val = $(this).val();
                $('#email').val(val+'@domain.com');
            });
        })
    </script>
@endpush
