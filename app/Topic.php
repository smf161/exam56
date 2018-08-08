<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'topic', 'exam_id', 'opt1', 'opt2', 'opt3', 'opt4', 'ans',
    ];

    public function exam() //從題目（topic）的角度來看

    {
        return $this->belongsTo('App\Exam');
    }

}
