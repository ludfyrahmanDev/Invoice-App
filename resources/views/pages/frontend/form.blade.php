@extends('layouts.front')
@section('content-app')

    <form id="steps" method="post" action="{{ route('form.submit') }}" class="show-section h-100" novalidate>
         <!-- step 2 -->
         @csrf
        @foreach ($data as $index => $d)
        <!-- step 1 -->
        <section class="steps">
            <div class="step-count">Step {{$index + 1}}/ {{count($data)}}</div>
            <h2 class="main-heading">{{$d->name}} ({{$d->category->name}})</h2>
            <div class="line-break"></div>

            <!-- form -->
            <fieldset class="form" id="step{{$index+1}}">
                <div class="row justify-content-space-between w-100">
                    <div class="rating">
                        @foreach ($d->question as $child => $question)
                        <h3>{{$question->name}}</h3>
                        @if($question->type == 'radio-range')
                        <div class="score">
                            <div class="score-inner delay-100ms">
                                @for($i=1; $i <= 5; $i++)
                                <input type="radio" name="question[{{ $question->id }}]" value='{{$i }}' class="score-point" required>
                                @endfor
                            </div>
                            <p><span>Sangat tidak setuju</span><span>Sangat Setuju</span></p>
                        </div>
                        @elseif($question->type == 'select')
                        @php
                            $value = json_decode($question->value);
                        @endphp
                        <select class="form-control" name="question[{{ $question->id }}]" required>
                            <option value="">Silahkan Pilih Opsi</option>
                            @foreach($value as $v)
                            <option value="{{$v}}">{{$v}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="{{$question->type}}" class="form-control" name="question[{{ $question->id }}]" placeholder="Input {{$question->name}}" required/>
                        @endif
                        <div class="line-break {{$question->type == 'radio-range' ? 'mt-5 mb-5' : 'mt-2 mb-2'}}"></div>
                        @endforeach

                    </div>
                </div>
            </fieldset>
            <div class="next-prev-button">
            @if($index+1 < count($data))
                @if($index != 0)
                    <button type="button" class="prev">Previous Question</button>
                @endif
                    <button type="button" class="next" id="stepbtn" value="{{$index+1}}">Next Question</button>
            @else
            <button type="submit" class="next" value="{{$index+1}}">Simpan</button>
            @endif
            </div>
        </section>
        @endforeach




    </form>
@endsection
