@extends('layouts.app')
@section('title','Quiz - ' .  $quiz_result->student->name . ' - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('quiz.show',['quiz'=>$quiz_result->quiz_id]) }}" class="btn btn-danger btn-sm">Back</a>
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>{{ $quiz_result->student->name }}</h6>
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

                            @csrf
                                @if ($data->count()>0)
                                <p>Multiple Choice</p>
                                <ol>
                                    @foreach($data as $question)
                                    @if ($question->question->category=='essay') @continue @endif
                                        <p> <span class="py-1 px-2 {{ $question->is_correct==1?'bg-success':'bg-danger' }} rounded-circle text-white mr-3">{{ $loop->iteration }}</span> {{ strip_tags($question->question->question) }}</p>
                                        <div class="form-group row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $question->answer=='1'?'checked':'' }}  class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_1">{{ $question->question->answer_1 }}</label> <i class="icon {{ $question->answer=='1'&&$question->is_correct==1?'icon-check text-success':($question->answer=='1'&&$question->is_correct==0?'icon-close text-danger':'') }}"></i>
                                                    <i class="icon {{ $question->is_correct==0&&$question->question->correct=='1'?'icon-check':'' }} text-success"></i>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $question->answer=='3'?'checked':'' }} class="custom-control-input" value="3">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_3">{{ $question->question->answer_3 }}</label><i class="icon {{ $question->answer=='3'&&$question->is_correct==1?'icon-check text-success':($question->answer=='3'&&$question->is_correct==0?'icon-close text-danger':'') }}"></i>
                                                    <i class="icon {{ $question->is_correct==0&&$question->question->correct=='3'?'icon-check':'' }} text-success"></i>
                                                </div>
                                                @if ($question->question->answer_5!=null)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $question->answer=='5'?'checked':'' }} class="custom-control-input" value="5">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_5">{{ $question->question->answer_5 }}</label><i class="icon {{ $question->answer=='5'&&$question->is_correct==1?'icon-check text-success':($question->answer=='5'&&$question->is_correct==0?'icon-close text-danger':'') }}"></i>
                                                    <i class="icon {{ $question->is_correct==0&&$question->question->correct=='5'?'icon-check':'' }} text-success"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $question->answer=='2'?'checked':'' }} class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_2">{{ $question->question->answer_2 }}</label><i class="icon {{ $question->answer=='2'&&$question->is_correct==1?'icon-check text-success':($question->answer=='2'&&$question->is_correct==0?'icon-close text-danger':'') }}"></i>
                                                    <i class="icon {{ $question->is_correct==0&&$question->question->correct=='2'?'icon-check':'' }} text-success"></i>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $question->answer=='4'?'checked':'' }} class="custom-control-input" value="4">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_4">{{ $question->question->answer_4 }}</label><i class="icon {{ $question->answer=='4'&&$question->is_correct==1?'icon-check text-success':($question->answer=='4'&&$question->is_correct==0?'icon-close text-danger':'') }}"></i>
                                                    <i class="icon {{ $question->is_correct==0&&$question->question->correct=='4'?'icon-check':'' }} text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ol>
                                @endif
                            <hr>
                            @if ($essay->count()>0)
                                <p>Essay</p>
                                @foreach ($essay as $item)
                                    <p> <span class="py-1 px-2 bg-warning rounded-circle text-white mr-3">{{ $loop->iteration }}</span> {{ strip_tags($item->question->question) }}</p>
                                    <div class="form-group">
                                        <textarea name="essay_answer[]" readonly class="form-control" cols="30" rows="5">{{ $item->answer }}</textarea>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card no-b my-3 shadow">
                    <div class="card-header bg-white">
                        <h6>Informasi Quiz</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="questions"><strong>Jumlah Pertanyaan</strong></label>
                            <input type="text" id="questions" value="{{ $data->count() }}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category"><strong>Multiple choice jumlah jawaban benar</strong></label> <i class="icon icon-check text-success"></i>
                            <input type="text" value="{{ $correct }}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category"><strong>Multiple choice jumlah jawaban salah</strong></label> <i class="icon icon-close text-danger"></i>
                            <input type="text" value="{{ $incorrect }}" disabled
                                   class="form-control">
                        </div>
                        <form action="{{ route('quiz.update.nilai',['quiz_result'=>$quiz_result->id]) }}" method="post">
                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="category"><strong>Nilai siswa</strong></label>
                                <input type="text" required name="score" value="{{ $quiz_result->status==2?$quiz_result->score:'' }}" {{ $quiz_result->status==2?'disabled':'' }} class="form-control">
                                @if ($quiz_result->status!=2)
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-success mt-4">Tambah nilai siswa</button>
                                @endif
                            </div>
                        </form>
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/config-tiny.js') }}"></script>
@endpush


