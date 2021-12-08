@extends('layouts.app')
@section('title','Create Classroom - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Tambah Mata Pelajaran Baru pada kelas {{ $room->name }}</h6>
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

                        <form action="{{ route('classroom.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="enroll_code" id="enroll">
                            <div class="form-group">
                                <label for="name">Nama Mata Pelajaran</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="editor">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>

                            {{-- <div class="form-group">
                                <label for="enroll">Enroll Code</label>
                                <input type="text" name="enroll_code" id="enroll" class="form-control" value="{{ old('enroll_code') }}">
                            </div> --}}

                            <div class="form-group">
                                <label for="status">Kelas</label>
                                <select name="room_id" id="user_id" class="form-control">
                                        <option value="{{ $room->id }}" selected>{{ $room->name }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Guru</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}" {{ $loop->index==0?'selected':'' }}>{{ $item->name }} - {{ $item->username }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <a href="{{ route('room.show',['room'=>$room->id]) }}" class="btn btn-danger btn-sm">Cancel</a>
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/config-tiny.js') }}"></script>
    <script>
        $(function(){
            $('#name').keyup(function (e) {
                var val = $(this).val();
                var low = val.toLowerCase();
                var str = low.split(' ').join('-')
                $('#enroll').val(str);
            });
        })
    </script>
@endpush


