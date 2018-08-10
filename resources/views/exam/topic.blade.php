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
                {{ bs()->hidden("ans[$topic->id]", 0) }}
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