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

         static::deleted(function($answer){
             $answer->question->decrement('answers_count');
         });
     }

    /***
     * ACCESOR
     */
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    
    public function getBestAnswerStatusAttribute(){
        if($this->id === $this->question->best_answer_id){
            
            return "text-success";
        }
        return "text-dark";
    }

    public function getIsBestAttribute(){
        // dd('hello');
        return $this->id === $this->question->best_answer_id;
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

    public function votes(){
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }

    /**
     * HELPER FUNCTIONS
     */

    public function vote(int $vote){
        $this->votes()->attach(auth()->id(), [ 'vote'=>$vote]);
        if($vote < 0){
            $this->decrement('votes_count');
        }
        else{
            $this->increment('votes_count');
        }
    }

    public function updateVote(int $vote){
        //User may have already up-voted this questin and now down-votes (votes_cont = 9)  strt - vc - 8, then up vc - 9 n now  decrmt - votes-count -8 (curent) now make it decrement ie +1 time decrement

        $this->votes()->updateExistingPivot(auth()->id(), ['vote'=>$vote]);
        if($vote < 0){
            $this->decrement('votes_count');
            $this->decrement('votes_count');
        }
        else{
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
    }
}