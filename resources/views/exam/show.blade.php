@extends('layouts.app')
@section('content')
    <h1>{{ $exam->title }}



        @can('建立測驗')
            {{-- <form action="{{route('exam.destroy', $exam->id)}}" method="POST" style="display:inline">
                @csrf
                @method('delete')
                <button type="submit"  class="btn btn-danger">刪除</button>
            </form> --}}

            <button type="button" class="btn btn-danger btn-del-exam" data-id="{{ $exam->id }}">刪除</button>
            
            <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-warning">編輯</a>
        @endcan
    
    
    </h1>

    {{-- 題目表單 --}}

    @can('建立測驗')


        @if(isset($topic))
            {{ bs()->openForm('patch', "/topic/{$topic->id}", ['model' => $topic]) }}
        @else
            {{ bs()->openForm('post', '/topic') }}
        @endif




        {{-- {{ bs()->openForm('post', '/topic') }} --}}
            {{ bs()->formGroup()
                    ->label('題目內容', false, 'text-sm-right')//true 則不顯示
                    ->control(bs()->textarea('topic')->placeholder('請輸入題目內容'))
                    ->showAsRow() }}
            {{ bs()->formGroup()
                    ->label('選項1', false, 'text-sm-right')
                    ->control(bs()->text('opt1')->placeholder('輸入選項1'))
                    ->showAsRow() }}
            {{ bs()->formGroup()
                    ->label('選項2', false, 'text-sm-right')
                    ->control(bs()->text('opt2')->placeholder('輸入選項2'))
                    ->showAsRow() }}
            {{ bs()->formGroup()
                    ->label('選項3', false, 'text-sm-right')
                    ->control(bs()->text('opt3')->placeholder('輸入選項3'))
                    ->showAsRow() }}
            {{ bs()->formGroup()
                    ->label('選項4', false, 'text-sm-right')
                    ->control(bs()->text('opt4')->placeholder('輸入選項4'))
                    ->showAsRow() }}

        {{ bs()->formGroup()
                ->label('正確解答', false, 'text-sm-right')
                ->control(bs()->radioGroup('ans', [1=>'1', 2=>'2', 3=>'3', 4=>'4'])
                        ->inline()
                        ->addRadioClass(['my-1','mx-3']))
                ->showAsRow() }}

        {{-- {{ bs()->formGroup()
                ->label('正確解答', false, 'text-sm-right')
                ->control(bs()->select('ans',[1=>1, 2=>2, 3=>3, 4=>4])->placeholder('請設定正確解答'))
                ->showAsRow() }} --}}



        {{ bs()->hidden('exam_id', $exam->id) }}
        {{ bs()->formGroup()
                ->label('')
                ->control(bs()->submit('儲存'))
                ->showAsRow() }}

        {{ bs()->closeForm() }}
    @endcan

    <div class="text-center">
        發佈於 {{$exam->created_at->format("Y年m月d日 H:i:s")}} / 最後更新： {{$exam->updated_at->format("Y年m月d日 H:i:s")}}
    </div>

    {{-- 題目列表 --}}

    {{-- @forelse($topics as $topic)
            <li>{{ $topic->topic }}</li>
    @empty
        <div class="alert alert-danger">
            尚無題目
        </div>
    @endforelse --}}

    {{-- 處理題號 --}}
    @forelse($exam->topics as $key=>$topic)
        <dl>
            <dt class="h3">
                {{-- 老師才看得到答案 --}}
                

                {{-- <form action="{{route('topic.destroy', $topic->id)}}"  method="post" style="display:inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">刪除</button>
                </form> --}}



                @can('建立測驗') 
                    <button type="button" class="btn btn-danger btn-del-topic" data-id="{{ $topic->id }}">刪除</button>
                    <a href="{{route('topic.edit', $topic->id)}}" class="btn btn-warning">編輯</a> 
                    ( {{$topic->ans}} )
                @endcan

                <span class="badge badge-success">{{ $key+1 }}</span>
                {{ $topic->topic }}
            </dt>
            <dd class="opt">
                {{ bs()->radioGroup("ans[$topic->id]", [
                    1 => "&#10102; $topic->opt1", 
                    2 => "&#10103; $topic->opt2",  
                    3 => "&#10104; $topic->opt3",  
                    4 => "&#10105; $topic->opt4", 
                    ])
                    ->selectedOption((Auth::user() and Auth::user()->can('建立測驗'))?$topic->ans:0) //老師才看得到答案
                    //->inline() //直排或橫排
                    ->addRadioClass(['my-1','mx-3'])
                }}



            </dd>
        </dl>
    @empty
        <div class="alert alert-danger">
            尚無題目
        </div>
    @endforelse





@endsection

@section('Js')
    <script>
        $(document).ready(function() {
            // 刪除題目按鈕點擊事件
            $('.btn-del-topic').click(function() {
                // 獲取按鈕上 data-id 屬性的值，也就是編號
                var topic_id = $(this).data('id');
                // 調用 sweetalert
                swal({
                    title: "確定要刪除題目嗎？",
                    text: "刪除後該題目就消失救不回來囉！",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是！含淚刪除！",
                    cancelButtonText: "不...別刪",
                }).then((result) => {
                    if (result.value) {
                        swal("OK！刪掉題目惹！", "該題目已經隨風而逝了...", "success");
                        // 調用刪除介面，用 id 來拼接出請求的 url
                        axios.delete('/topic/' + topic_id).then(function () {
                            location.reload();
                        });
                    }
                });
            });

            // 刪除測驗按鈕點擊事件
            // $('.btn-del-exam').click(function() {
            //     // 獲取按鈕上 data-id 屬性的值，也就是編號
            //     var exam_id = $(this).data('id');
            //     // 調用 sweetalert
            //     swal({
            //         title: "確定要刪除測驗嗎？",
            //         text: "刪除後該測驗就消失救不回來囉！",
            //         type: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: "#DD6B55",
            //         confirmButtonText: "是！含淚刪除！",
            //         cancelButtonText: "不...別刪",
            //     }).then((result) => {
            //         if (result.value) {
            //             swal("OK！刪掉測驗惹！", "該測驗已經隨風而逝了...", "success");
            //             // 調用刪除介面，用 id 來拼接出請求的 url
            //             axios.delete('/exam/' + exam_id).then(function () {
            //                 location.href='/';
            //             });
            //         }
            //     });
            // });
            
            //方法二,刪除才告知己經刪除了
            $('.btn-del-exam').click(function(){
                var exam_id=$(this).data('id');                
                swal({
                    title: "確定要刪除測驗嗎？",
                    text: "測驗刪除後該測驗及所有題目就消失救不回來囉！",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是！含淚刪除！",
                    cancelButtonText: "不...別刪",
                }).then((result) => {
                    if (result.value) {                        
                        axios.delete('/exam/' + exam_id)
                        .then(function(){
                            return swal("OK！刪掉題目惹！", "該題目已經隨風而逝了...", "success");
                        }).then(function () {
                            location.href='/';
                        });
                    }
                })
            });

            
        });
    </script>
@endsection

