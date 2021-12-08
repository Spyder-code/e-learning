@extends('layouts.app')
@section('title','Data Kelas - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Kelas {{ $room->name }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 mb-4">
                            <a href="{{ route('classroom.create',['room'=>$room->id])}}" class="btn btn-primary btn-sm"><i
                                    class="icon icon-add"></i>Tambah Mata Pelajaran</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Mata pelajaran</th>
                                    <th>Guru pengampu</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classrooms as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->lecturer->name }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('classroom.edit', $item['id']) }}" class="btn btn-primary btn-xs mr-2"><i class="icon icon-pencil"></i>Ubah</a>
                                            <form action="{{ route('classroom.destroy',['classroom'=>$item['id']]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="icon icon-trash"></i>Hapus</button>
                                            </form>
                                            {{-- <button onclick="deleteAkun('{{ $item['id'] }}', '{{ $item['name'] }}')"
                                                    class="btn btn-danger btn-xs"><i
                                                    class="icon icon-trash"></i>Hapus
                                            </button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card my-3">
                    <div class="card shadow no-b">
                        <div class="card-header bg-white">
                            <span class="card-title"><strong>Tambah Siswa</strong></span>
                            {{-- <span class="float-right">
                                <a href="{{ route('classroom.student', $classroom) }}">Lihat Semua</a>
                            </span> --}}
                        </div>
                        <div class="card-body">
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            <form action="{{ route('students.invite') }}" method="POST">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div class="form-group">
                                    <label for="student">Invite Siswa</label>
                                    <select name="students[]" id="student" class="form-control"
                                            multiple></select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Invite</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Data siswa kelas {{ $room->name }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama siswa</th>
                                    <th>NIS</th>
                                    <th>Email</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($room['students'] as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td class="d-flex">
                                            <form action="{{ route('drop.siswa') }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="name" value="{{ $item->name }}">
                                                <input type="hidden" name="user_id" value="{{ $item->id }}">
                                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="icon icon-trash"></i>Drop siswa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.dataTable').DataTable({
            "responsive": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ per halaman",
                "zeroRecords": "Tidak ada data",
                "info": "Tampilkan _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "",
                "search": "Cari Data :",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#student').select2({
            ajax: {
                url: '{{ route('students.ajax') }}',
                data: function (params) {
                    return {
                        q: params.term,
                        room_id: '{{ $room['id'] }}'

                    }
                },
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name + " (" + item.email + ")"
                            }
                        })
                    }
                }
            },
            cache: true
        });

        @if(Session::has('success'))
            swal("Berhasil !", '{{ Session::get('success') }}', "success");
        @endif
    </script>

@endpush
