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
                        <a href="{{ route('classroom.show', $classroom) }}" class="btn btn-primary btn-xs mr-2"><i
                                class="icon-arrow_back"></i> Back</a>
                        <span class="card-title">Siswa (Participant)</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Lihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($absensi as $item)
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($item[0]->date)) }}</td>
                                        <td>
                                            <a href="{{ route('absensi.date',['classroom'=>$classroom->id, 'date'=>$item[0]->date]) }}" class="btn btn-primary btn-xs"><i class="icon icon-eye"></i>Lihat absensi siswa</a>
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
