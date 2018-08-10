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

    public function topics()
    {
        //關聯
        return $this->hasMany('App\Topic');
    }

    public function user()
    //關聯
    {
        return $this->belongsTo('App\User');
    }
}
