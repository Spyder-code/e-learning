@extends('layouts.app')
@section('title','Data Kelas - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Data Kelas</h6>
                    </div>
                    <div class="card-body">
                        {{-- <div class="col-md-12 mb-4">
                            <a href="{{ route('room.create')}}" class="btn btn-primary btn-sm"><i
                                    class="icon icon-add"></i>Tambah Kelas</a>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>
                                            <form action="{{ route('room.update',['room'=>$item->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" onselect="submit()">
                                            </form>
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('room.show', ['room'=>$item->id]) }}"
                                               class="btn btn-warning btn-xs mr-2"><i
                                                    class="icon icon-eye"></i>Lihat</a>
                                            <form action="{{ route('room.destroy',['room'=>$item['id']]) }}" method="post">
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
                    <div class="card-header text-white bg-success">
                        Tambah kelas
                    </div>
                    <div class="card-body">
                        <form action="{{ route('room.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nama kelas</label>
                                <input type="text" required name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>
                            <button class="btn btn-success btn-sm" type="submit">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#data-table').DataTable({
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

        @if(Session::has('success'))
            swal("Berhasil !", '{{ Session::get('success') }}', "success");
        @endif

    </script>

@endpush
