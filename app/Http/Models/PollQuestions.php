<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30/05/2018
 * Time: 11:42 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class PollQuestions extends Model
{

    protected $table = 'poll_questions';
    protected $primaryKey = 'poll_questions_id';
    protected $fillable = [
        'question_ar',
        'question_en',
        'question_ur',
        'poll_id'
    ];


    public function PollAnswer()
    {
        return $this->hasMany('App\Http\Models\PollAnswer','poll_question_id');
    }

    public function getQuestionArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->question_en;
        if (APP::getLocale() == 'ur')
            $value = $this->question_ur;
        return $value;

    }


}