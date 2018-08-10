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
        @include('exam.form');//程式碼外移
    @endcan

    {{-- 題目列表 --}}
    {{-- 進行測驗學生產生表單及交卷按鈕 --}}
    @if(Auth::check())
        @can('進行測驗')

            {{ bs()->openForm('post', '/test') }}

            @include('exam.topic');
            
            {{ bs()->hidden('exam_id', $exam->id) }}
            {{ bs()->hidden('user_id', Auth::id()) }}
            <div class="text-center my-5">
                {{ bs()->submit('交卷')->sizeLarge() }}
            </div>
            {{ bs()->closeForm() }}
        @else        
            @include('exam.topic');
        @endcan
    @else
        <div class="alert alert-info">
            <h3>本測驗共有 {{ $exam->topics->count() }} 題，登入後始能進行測驗或編輯題目</h3>
        </div>
    @endif  


        <div class="text-center">
            {{ $exam->user->name }} ({{ $exam->user->email }}) 發佈於 {{ $exam->created_at->format("Y年m月d日 H:i:s") }} / 最後更新： {{ $exam->updated_at->format("Y年m月d日 H:i:s") }}
        </div>

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

