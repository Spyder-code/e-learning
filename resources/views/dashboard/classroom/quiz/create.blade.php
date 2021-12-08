@extends('layouts.app')
@section('title','Create Quiz - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Edit Quiz</h6>
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
                        <form action="{{ route('quiz.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $classroom['id'] }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name') }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="UTS">UTS</option>
                                            <option value="UAS">UAS</option>
                                            <option value="TUGAS">Tugas</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="start_date">Waktu Mulai <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="date-time-picker form-control"
                                                           name="start_date"
                                                           data-options='{"timepicker":true, "format":"d-m-Y H:m"}'
                                                           value="{{ old('start_date') }}" required/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text add-on white">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_date">Waktu Selesai <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="date-time-picker form-control"
                                                           name="end_date"
                                                           data-options='{"timepicker":true, "format":"d-m-Y H:m"}'
                                                           value="{{ old('end_date') }}" required/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text add-on white">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="password">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="password" id="password" class="form-control"
                                               value="{{ old('password') }}" required>
                                    </div> --}}
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editor">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top border-list mb-4 pt-3">
                                <div class="col-12">
                                    <h6>Soal Multiple Choice</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover dataTable" id="data-table" style="width: 1700px">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Pertanyaan</th>
                                                <th>Jawaban A</th>
                                                <th>Jawaban B</th>
                                                <th>Jawaban C</th>
                                                <th>Jawaban D</th>
                                                <th>Jawaban E</th>
                                                <th>Jawaban Benar</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                <tr id="tr-content">
                                                    <td class="no-choice">1.</td>
                                                    <td>
                                                        <textarea name="question[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('question[]') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_1[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('answer_1[]') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_2[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('answer_2') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_3[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('answer_3[]') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_4[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('answer_4[]') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_5[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ old('answer_5[]') }}</textarea>
                                                    </td>
                                                    <td>
                                                        <select name="correct[]" class="form-control">
                                                            <option value="1">A</option>
                                                            <option value="2">B</option>
                                                            <option value="3">C</option>
                                                            <option value="4">D</option>
                                                            <option value="5">E</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn-sm btn btn-success mt-3" type="button" id="add-choice">Add question multiple choice</button>
                                </div>
                                <div class="col-md-12 border-top mt-4">
                                    <div class="row mt-5">
                                        <div class="col-md-6">
                                            <h6>Soal Essay</h6>
                                        </div>
                                    </div>
                                        <div class="d-flex">
                                            <p class="mr-3 mt-2">1.</p>
                                            <div class="input-group mt-2">
                                                <textarea name="essay[]" rows="2" class="form-control"></textarea>
                                                <div class="input-group-append" style="cursor: pointer">
                                                    <span class="input-group-text add-on">
                                                        <i class="icon-check text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="essay"></div>
                                    <button class="btn-sm btn btn-success mt-3" type="button" id="add-essay">Add question essay</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('classroom.show',['classroom'=>$classroom->id]) }}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm float-right" onclick="return confirm('Apakah anda sudah yakin? silahkan cek terlebih dahulu sebelum melanjutkan')">Create</button>
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
        let counter = 1;
        let optionCounter = 1;

        @if(old('questions'))
            counter = parseInt('{{ count(old('questions')) }}');
        optionCounter = parseInt($('#option-helper').val());

        @endif

        var content = $('#tr-content').html();

        var noc=1;
        $('#add-choice').click(function (e) {
            noc++;
            var a = $('.no-choice').length;
            $('#tbody').append('<tr>'+content+'</tr>');
            var no = $(".no-choice:eq("+a+")").html(noc);
        });

        var no = 1;
        $('#add-essay').click(function (e) {
            no++;
            var html = '<div class="d-flex"><p class="mr-3 mt-2">'+no+'</p><div class="input-group mt-2"><textarea name="essay[]" rows="2" class="form-control"></textarea><div class="input-group-append" style="cursor: pointer"><span class="input-group-text add-on"><i class="icon-check text-success"></i></span></div></div></div>';
            $('#essay').append(html);
        });
    </script>
@endpush


