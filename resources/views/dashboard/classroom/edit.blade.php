@extends('layouts.app')
@section('title','Edit Classroom - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Edit Kelas</h6>
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

                        <form action="{{ route('classroom.update', $classroom) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="name">Nama mata pelajaran</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ $classroom['name'] }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="editor">Deskripsi</label>
                                <textarea name="description" class="form-control"
                                          rows="5">{{ $classroom['description'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">Guru pengampu</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}" {{ $item->id==$classroom['user_id']?'selected':'' }}>{{ $item->name }} - {{ $item->username }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <a href="{{ route('room.show', ['room'=>$classroom->room_id]) }}" class="btn btn-danger btn-sm">Cancel</a>
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
@endpush


