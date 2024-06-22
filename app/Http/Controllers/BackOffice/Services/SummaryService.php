<?php

namespace App\Http\Controllers\BackOffice\Services;

use App\Constants\ItemType;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Answer;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Form;
use App\Shareds\BaseService;
use Carbon\Carbon;
class SummaryService
{
    public function __construct()
    {

    }

    public function getSummary($request){
        $date  = date('Y-m-d');
        $now = Carbon::now();
        $today = Answer::whereDate('created_at', $date)->get()->groupBy('key')->count();
        $week = Answer::whereBetween('created_at',[
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            $now->endOfWeek()->format('Y-m-d')
        ])->get()->groupBy('key')->count();;
        $month = Answer::whereMonth('created_at', $date)->get()->groupBy('key')->count();
        $year = Answer::whereYear('created_at', $date)->get()->groupBy('key')->count();
        $summary = Category::with('subcategory', 'subcategory.question', 'subcategory.question.answer')->get();
        $chart = null;
        foreach ($summary as $summaryKey => $s) {
            $subcategory = [];
            foreach ($s->subcategory as $subKey => $sub) {
                $questions = ['name' => $sub->name, 'child' => []];
                foreach ($sub->question as $questionKey => $question) {
                    if($question->type != 'radio-range' && $question->type !='select') {
                        continue;
                    }else{
                        $childQuestion =['name' => $question->name, 'answer' => [], 'id' => $question->id];
                        $answerChild = [];
                        foreach ($question->answer as $answerKey => $answer) {
                            $answerChild[] = $answer->answer;
                        }
                        $keyAnswer = array_count_values($answerChild);
                        $finalQuestion = $childQuestion;
                        foreach ($keyAnswer as $answerKeyIndication => $answerFinal) {
                            $finalQuestion['answer']['label'][] = "$answerKeyIndication";
                            $finalQuestion['answer']['value'][] = $answerFinal;
                        }
                        $questions['child'][] = $finalQuestion;
                    }

                }
                $subcategory[] = $questions;
            }

            $array = ['category' => $s->name, 'subcategory' => $subcategory];
            $chart[] = $array;
        }
        return (object)[
            'today' => $today,
            'week' => $week,
            'month' => $month,
            'year' => $year,
            'chart' => $chart
        ];
    }

    public function getCalculation($request){
        $usability_id = $request->usability_id ?? 2;
        $form = Form::with('subcategory', 'subcategory.category')->whereHas('subcategory.category', function($query) use ($usability_id){
            $query->where('id', $usability_id);
        })->get();
        $sub = SubCategory::with('question', 'question.answer')->where('category_id',$usability_id)->get();
        $answer = Answer::with(['form','form.subcategory', 'form.subcategory.category'])->whereHas('form.subcategory', function($query) use ($usability_id){
            $query->where('category_id', $usability_id);
        })->get()->groupBy('key');
        $totalBottom = Answer::with(['form','form.subcategory', 'form.subcategory.category'])->whereHas('form.subcategory', function($query) use ($usability_id){
            $query->where('category_id', $usability_id);
        })->get()->groupBy('form_id');
        return [$sub, $answer, $form, $totalBottom];
    }

}
