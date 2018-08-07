<?php
//模型

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //store方法二需要的
    protected $fillable = [
        'title', 'user_id', 'enable',
    ];

    protected $casts = [
        'enable' => 'boolean',
    ];
}
