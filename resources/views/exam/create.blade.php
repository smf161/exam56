@extends('layouts.app') 
@section('content')
    <h1>{{ __('Create Exam') }}</h1>
    @can('建立測驗')
        {{-- 因為編輯造成error,所以加了判斷,另外給ID,用雙引號 --}}
        
        @if(isset($exam))
            {{ bs()->openForm('patch', "/exam/{$exam->id}" , [ 'model' => $exam]) }}
        @else
            {{ bs()->openForm('post', '/exam') }}
        @endif

        {{-- {{ bs()->openForm('post', '/exam',['model' => $exam, ]) }}  --}}

        {{ bs()->formGroup()
            ->label('測驗標題', false, 'text-sm-right')
            ->control(bs()->text('title')->placeholder('請填入測驗標題'))
            ->showAsRow() }}

            {{ bs()->hidden('user_id', Auth::id()) }}



            {{-- {{ bs()->text('title')->placeholder('請填入測驗標題') }}
            {{ bs()->select('enable', ['1' => '開啟', '0' => '關閉'], '1') }}
            {{ bs()->checkbox('enable1')->description('記住我')->checked() }}

            {{ bs()->radioGroup('enable2', [1 => '啟用', 0 => '關閉'])
                ->selectedOption(1)
                ->inline() }} --}}

            {{ bs()->formGroup()
                ->label('是否啟用', false, 'text-sm-right')
                ->control(bs()->radioGroup('enable', [1 => '啟用', 0 => '關閉'])
                    //->selectedOption(1)
                    //->selectedOption(isset($exam)?$exam->enable:1) //編輯時,要變更為選擇,可以不用
                    ->inline())
                ->showAsRow() }}

            {{ bs()->submit('儲存') }}

            {{ bs()->closeForm() }}
        @else    

        {{-- @component('bs::alert', ['type' => 'danger'])
            @slot('heading')
                沒有操作的權限
            @endslot
            <p>請先登入，或有相關權限者始能建立測驗</p>
        @endcomponent --}}

        <div class="alert alert-danger">
            <h2>沒有操作的權限</h2>
            <p>請先登入，或有相關權限者始能建立測驗</p>
        </div>
    @endcan
@endsection