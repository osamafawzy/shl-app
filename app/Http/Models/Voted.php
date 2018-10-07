<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30/05/2018
 * Time: 11:50 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Voted extends Model
{

    protected $table = 'voted';
    protected  $primaryKey = 'voted_id';
    protected $fillable = [
        'poll_id',
        'poll_question_id',
        'poll_answer_id',
        'user_id',
    ];

}

#App\Poll::find($id)->with('questions');
#