@extends('layouts.app')
@section('content')
{{-- 輸出主內容 --}}
    <h1>隨機題庫系統</h1>

    <div class="list-group">
        @forelse($exams as $exam)
            <a href="exam/{{$exam->id}}" class="list-group-item list-group-item-action">
                {{$exam->updated_at->format("Y年m月d日")}}
                {{ $exam->title }}
            </a>
        @empty
            <div class="alert alert-danger">
                尚無任何測驗
            </div>
        @endforelse
    </div>

@endsection


{{-- @section('my_menu')
    @parent
    <li><a class="nav-link" href="/add">新增題庫</a></li>
@stop --}}