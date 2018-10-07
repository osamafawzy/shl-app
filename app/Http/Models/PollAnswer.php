<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30/05/2018
 * Time: 11:49 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class PollAnswer extends Model
{

    protected $table = 'poll_answer';
    protected  $primaryKey = 'poll_answer_id';
    protected $fillable = [
        'answer_ar',
        'answer_en',
        'answer_ur',
        'poll_question_id'
    ];

    public function getAnswerArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->answer_en;
        if (APP::getLocale() == 'ur')
            $value = $this->answer_ur;
        return $value;

    }

}