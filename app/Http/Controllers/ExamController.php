<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;

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
        $exams = Exam::where(function ($query) {
            $query->where('enable', 1)
                ->orWhere('user_id', 1);
        })
            ->orderBy('created_at', 'desc')
        //->take(1) //限制筆數,做分頁有另外寫法
            ->paginate(2);
        //->get();
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(ExamRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
