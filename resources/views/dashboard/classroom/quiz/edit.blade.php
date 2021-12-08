@extends('layouts.app')
@section('title','Edit Quiz - ')
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
                        <form action="{{ route('quiz.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="classroom_id" value="{{ $classroom['id'] }}">
                            <input type="hidden" name="quiz_id" value="{{ $quiz['id'] }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ $quiz->name }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            {{-- @foreach($categories as $item)
                                                <option
                                                    value="{{ $item['id'] }}" {{ old('category_id') == $item['id'] ? 'selected': '' }}>{{ $item['name'] }}</option>
                                            @endforeach --}}
                                            <option value="UTS" {{ $quiz->category=='UTS'?'selected':'' }}>UTS</option>
                                            <option value="UAS" {{ $quiz->category=='UAS'?'selected':'' }}>UAS</option>
                                            <option value="TUGAS" {{ $quiz->category=='TUGAS'?'selected':'' }}>Tugas</option>
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
                                                           value="{{ $quiz->start_date }}" required/>
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
                                                           value="{{ $quiz->end_date }}" required/>
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
                                        <textarea name="description" class="form-control" rows="5">{{ $quiz->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top border-list mb-4 pt-3">
                                <div class="col-12">
                                    <h6>Soal Multiple Choice</h6>
                                    @if ($choice->count()>0)
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
                                            <tbody>
                                            @foreach($choice as $item)
                                            <input type="hidden" name="id_choice[]" value="{{ $item->id }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <textarea name="question[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->question }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_1[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->answer_1 }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_2[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->answer_2 }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_3[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->answer_3 }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_4[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->answer_4 }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="answer_5[]" cols="30" rows="2" class="form-control" style="font-size: 9pt">{{ $item->answer_5 }}</textarea>
                                                    </td>
                                                    <td>
                                                        <select name="correct[]" class="form-control">
                                                            <option value="1" {{ $item->correct=='1'?'selected':'' }}>A</option>
                                                            <option value="2" {{ $item->correct=='2'?'selected':'' }}>B</option>
                                                            <option value="3" {{ $item->correct=='3'?'selected':'' }}>C</option>
                                                            <option value="4" {{ $item->correct=='4'?'selected':'' }}>D</option>
                                                            <option value="5" {{ $item->correct=='5'?'selected':'' }}>E</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </div>
                                    @endif
                                </div>
                                @if ($essay->count()>0)
                                <div class="col-md-12 border-top mt-4">
                                    <div class="row mt-5">
                                        <div class="col-md-6">
                                            <h6>Soal Essay</h6>
                                        </div>
                                    </div>
                                    @foreach ($essay as $item)
                                    <input type="hidden" name="id_essay[]" value="{{ $item->id }}">
                                        <div class="d-flex">
                                            <p class="mr-3 mt-2">{{ $loop->iteration }}.</p>
                                            <div class="input-group mt-2">
                                                <textarea name="essay[]" rows="2" class="form-control">{{ $item->question }}</textarea>
                                                <div class="input-group-append" style="cursor: pointer">
                                                    <span class="input-group-text add-on">
                                                        <i class="icon-check text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <a href="{{ route('classroom.show',['classroom'=>$classroom->id]) }}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm float-right">Update</button>
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


        function addOption(e) {
            let i = $(e).data('id');
            optionCounter = optionCounter + 1;
            let optionfield = $(e).parents('.option');
            let uniqueKey = Math.random().toString(36).substr(2, 9);
            optionfield.append("<div class=\"col-md-11 mb-2\">\n" +
                "                                                <div class=\"input-group\">\n" +
                "                                                    <div class=\"input-group-append\">\n" +
                "                                                        <div class=\"input-group-text\">\n" +
                "                                                            <div class=\"custom-control custom-radio custom-control-inline\" onclick=\"clicked(this," + i.toString() + ")\">\n" +
                "                                                                <input type=\"radio\" name=\"answer" + i + "\" value=\"true\" id=\"" + uniqueKey + "\" required=\"required\" class=\"custom-control-input\">\n" +
                "                                                                <label for=\"" + uniqueKey + "\" class=\"custom-control-label\">Tetapkan Sebagai Jawaban</label></div>\n" +
                "                                                        </div>\n" +
                "                                                    </div>\n" +
                "                                            <textarea\n" +
                "                                                class=\"form-control\"\n" +
                "                                                type=\"text\" required\n" +
                "                                                name=\"questions[" + i + "][options][" + optionCounter + "][content]\"></textarea>\n" +
                "                                                    <div class=\"input-group-append\" onclick=\"$(this).parents()[1].remove()\"\n" +
                "                                                         style=\"cursor: pointer\">\n" +
                "                                                        <div class=\"input-group-text\">\n" +
                "                                                            <i class=\"text-danger icon-trash\"></i>\n" +
                "                                                        </div>\n" +
                "                                                    </div>\n" +
                "                                                </div>\n" +
                "                                            </div>")
        }

        $("#add-question").click(function (e) {
            counter = counter + 1;
            let uniqueKey = Math.random().toString(36).substr(2, 9);
            $('#question-area').append('                                <div class="col-md-12 mb-2">\n' +
                '                                    <div class="form-group">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <textarea name="questions[' + counter + '0][content]" rows="2"\n' +
                '                                                      class="form-control"></textarea>\n' +
                '                                            <div class="input-group-append" onclick="$(this).parents()[2].remove()" style="cursor: pointer">\n' +
                '                                                        <span class="input-group-text add-on">\n' +
                '                                                            <i class="icon-trash text-danger"></i>\n' +
                '                                                        </span>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '\n' +
                '                                        <h6 class="mt-3">Pilihan / Option :</h6>\n' +
                '                                        <div class="row justify-content-end option">\n' +
                '                                            <div class="col-md-11 mb-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <div class="input-group-append">\n' +
                '                                                        <div class="input-group-text">\n' +
                '                                                            <div\n' +
                '                                                                class="custom-control custom-radio custom-control-inline" onclick="clicked(this, ' + counter + '0)">\n' +
                '                                                                <input type="radio" name="answer' + counter + '0"\n' +
                '                                                                       value="true" id="' + uniqueKey + '" required="required"\n' +
                '                                                                       class="custom-control-input">\n' +
                '                                                                <label for="' + uniqueKey + '" class="custom-control-label">Tetapkan\n' +
                '                                                                    Sebagai Jawaban</label></div>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <textarea\n' +
                '                                                        class="form-control"\n' +
                '                                                        type="text" required\n' +
                '                                                        name="questions[' + counter + '0][options][' + counter + '][content]"></textarea>\n' +
                '                                                    <div class="input-group-append" data-id="' + counter + '0" onclick="addOption(this)"\n' +
                '                                                         style="cursor: pointer">\n' +
                '                                                        <div class="input-group-text">\n' +
                '                                                            <i class="text-success icon-plus-circle"></i>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>')
        });


        let lastClick = null;

        function clicked(e, i) {
            const now = Date.now();
            const DOUBLE_PRESS_DELAY = 300;
            if (lastClick && (now - lastClick) < DOUBLE_PRESS_DELAY) {
                let el = $(e).parent().parent().parent().find('textarea');
                let text = el.attr('name');
                text = text.replace('content', 'answer');
                console.log(el.parents(3).find("." + i).remove());
                el.after('<input type="hidden" class="' + i + '" name="' + text + ':boolean" value="true">')
            } else {
                lastClick = now;
            }
        }

        $('#add-essay').click(function (e) {
            console.log("essay-created");
            var html = '<div class="input-group mt-2"> <textarea name="essay[]" rows="2" class="form-control"></textarea> <div class="input-group-append" style="cursor: pointer"> <span class="input-group-text add-on"> <i class="icon-check text-success"></i> </span> </div></div>';
            $('#essay').append(html);
        });
    </script>
@endpush


