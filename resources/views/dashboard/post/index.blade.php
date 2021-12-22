@extends('layouts.app')
@section('title','Data Post - ')
@section('content')
<div class="container-fluid my-3">
   <div class="row">
      <div class="col-md-12">
         <div class="card no-b my-3 shadow">
            <div class="card-header white">
               <h6>Data {{ $name }}</h6>
            </div>
            <div class="card-body">
               <div class="col-md-12 mb-4">
                  <a href="{{ route('post.create') }}" class="btn btn-primary btn-sm"><i
                        class="icon icon-add"></i>Tambah {{ $name }}</a>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered table-hover dataTable" id="data-table">
                     <thead>
                        <tr>
                           <th>No.</th>
                           <th>Judul</th>
                           <th>Kategori</th>
                           <th>Created On</th>
                           <th width="20%">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($post as $item)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $item->title }}</td>
                           <td>{{ $item->category->name }}</td>
                           <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                           </td>
                           <td class="d-flex">
                              <a href="{{ route('post.edit', $item) }}" class="btn btn-primary btn-xs mr-2"><i
                                    class="icon icon-pencil"></i>Ubah</a>
                              <form action="{{ route('post.destroy', $item) }}" method="post">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit"
                                    onclick="return confirm('Apakah kamu yakin menghapus {{ $item->title }}?')"
                                    class="btn btn-danger btn-xs"><i class="icon icon-trash"></i>Hapus</button>
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
$('#data-table').DataTable({
   "columnDefs": [{
      "targets": 4,
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

@if(Session::has('success'))
swal("Berhasil !", '{{ Session::get('
   success ') }}', "success");
@endif
</script>
@endpush