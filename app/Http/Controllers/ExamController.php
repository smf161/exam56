<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$exams = Exam::all();
        //$exams = Exam::where('enable', 1)

        // $exams = Exam::where(function ($query) {
        //     $query->where('enable', 1)
        //         ->orWhere('user_id', 1);
        // })
        // //->orderBy('created_at', 'desc')
        //     ->orderBy('created_at', 'asc')
        // //->take(1) //限制筆數,做分頁有另外寫法
        //     ->paginate(2); //做分頁
        // //->get();

        if (Auth::check() and Auth::user()->can('建立測驗')) {
            $exams = Exam::orderBy('created_at', 'desc')
                ->paginate(3);
        } else {
            $exams = Exam::where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(3);
        }

        return view('exam.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(ExamRequest $request)
    {
        // $this->validate($request, [
        //     'title' => 'required|min:2|max:191',
        // ], [
        //     'required' => '「:attribute」為必填欄位',
        //     'min'      => '「:attribute」至少要 :min 個字',
        //     'max'      => '「:attribute」最多只能 :max 個字',
        // ]);

        // store方法一
        // $exam          = new Exam;
        // $exam->title   = $request->title;
        // $exam->user_id = $request->user_id;
        // $exam->enable  = $request->enable;
        // $exam->save();
        // return redirect()->route('exam.index');

        //store方法二
        // Exam::create([
        //     'title'   => $request->title,
        //     'user_id' => $request->user_id,
        //     'enable'  => $request->enable,
        // ]);
        // return redirect()->route('exam.index');

        //store方法三最簡單
        Exam::create($request->all());
        return redirect()->route('exam.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //public function show($id) //取得的是id

    public function show(Exam $exam) //類型約束,取得的是資料全部

    {
        //學生登入,進行測驗
        $user = Auth::user();
        //檢查登入與否方法一
        if ($user and $user->can('進行測驗')) {
            $show_num = 5;
            if ($exam->topics->count() > $show_num) { //少於5題會出錯
                $exam->topics = $exam->topics->random($show_num); //抓題目,挑5題,再存回
            }
        }

        //$exam = Exam::find($id); //類型約束則不用
        //dd($exam);
        //return view('exam.show', compact('exam'));

        //$topics = Topic::where('exam_id', $exam->id)->get(); //有關聯就不用
        //return view('exam.show', compact('exam', 'topics')); //有關聯,不用再傳topics
        return view('exam.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam) //類型約束,取得的是資料全部

    {
        return view('exam.create', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->update($request->all());
        return redirect()->route('exam.show', $exam->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        //return redirect()->route('exam.index');
    }
}
