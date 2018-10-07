<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30/05/2018
 * Time: 11:40 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'poll';
    protected $fillable = ['state'];
    protected $primaryKey = 'poll_id';

    public function PollQuestion(){
        return $this->hasMany('App\Http\Models\PollQuestions','poll_id');
    }
}