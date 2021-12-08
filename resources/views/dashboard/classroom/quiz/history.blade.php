@extends('layouts.app')
@section('title','Quiz Result History - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('classroom.show',['classroom'=>$quiz->classroom_id]) }}" class="btn btn-danger btn-sm">Back</a>
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Quiz {{ $quiz->name }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th>Nama siswa</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->student->name }}</td>
                                    <td>{{ $item->score }}</td>
                                    <td>
                                        @if ($item->status==0)
                                            <div class="alert alert-danger">
                                                <strong>Belum mengerjakan</strong>
                                            </div>
                                        @elseif($item->status==1)
                                            <div class="alert alert-info">
                                                <strong>Belum dinilai</strong>
                                            </div>
                                        @else
                                            <div class="alert alert-success">
                                                <strong>Complete</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status==1)
                                            <a href="{{ route('quiz.detail',['classroom'=>$quiz->classroom_id,'quiz_result'=>$item->id]) }}" class="btn btn-sm btn-warning">Nilai siswa</a>
                                        @elseif($item->status==2)
                                            <a href="{{ route('quiz.detail',['classroom'=>$quiz->classroom_id,'quiz_result'=>$item->id]) }}" class="btn btn-sm btn-info">Lihat pekerjaan</a>
                                        @endif
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
@endsection
@push('js')
    {{-- @if(session()->has('error'))
        <script>
            swal("Oops!", '{{ session()->get('error') }}', "error");
        </script>
    @endif --}}

    <script>
        $('.dataTable').DataTable({
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
@endpush

