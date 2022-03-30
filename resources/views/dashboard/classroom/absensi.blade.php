@extends('layouts.app')
@section('title','Student Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <h3>
                {{ $classroom['name'] }}
            </h3>
            Dosen : <strong>{{ $classroom['lecturer']['name'] }}</strong>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow no-b">
                    <div class="card-header bg-white">
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-xs mr-2"><i
                                class="icon-arrow_back"></i> Back</a>
                        <span class="card-title">{{ date('d-m-Y', strtotime($date)) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <form action="{{ route('absensi.update',['attendance'=>$item->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <select name="information" class="form-control" onchange="submit()">
                                                    <option value="H" {{ $item->information=='H'?'selected':'' }}>Hadir</option>
                                                    <option value="I" {{ $item->information=='I'?'selected':'' }}>Izin</option>
                                                    <option value="A" {{ $item->information=='A'?'selected':'' }}>Alpha</option>
                                                </select>
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
        @if(session()->has('success'))
        swal("Berhasil !", '{{ session()->get('success') }}', "success");
        @endif

    </script>

    <script>
        $('#data-table').DataTable({
            "columnDefs": [{
                "orderable": false
            }],
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

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
@endpush
