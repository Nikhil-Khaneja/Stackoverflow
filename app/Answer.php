<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded =[];
     public static function boot(){
         parent::boot();
         static::created(function($answer){
             $answer->question->increment('answers_count');
         });
     }

    /***
     * ACCESOR
     */
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    
   

    /*
     * RELATIOSHIP METHODS
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}