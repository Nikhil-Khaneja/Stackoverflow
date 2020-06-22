<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $guarded = [];

    /**
     * MUTATORS - These are soecial functions which have setXXXAttribute($value);
     */
    /** attributes is given by model class so you can add any field you want to add and when you are gonna add the data in db it will check 
     * the fields on that time and add, it is like  an array 
     */
    public function setTitleAttribute($title){
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    } 
/*
    * Accesors - These are special functions which have getXXXAttribute()
    */
   public function getUrlAttribute(){
       return "questions/{$this->slug}";
   }
   public function getCreatedDateAttribute(){
       return $this->created_at->diffForHumans();
   }
   public function getAnswersStyleAttribute(){
       if($this->answers_count > 0){
           if($this->best_answer_id){
               return "has-best-answer";
           }
           return "answered";
       }
       return "unanswered";
   }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoriteAttribute()
    {
        return $this->favorites()->where(['user_id'=>auth()->id()])->count() > 0;
    }

    //    public function getFullNameAttribute(){
//        return $this->first_name. " " .$this->last_name;
//    }
   
    /**
     * RELATIONSHIP METHODNJS
     */
    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function favorites(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function votes(){
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    /**
     * HELPER FUNCTION
     */
    public function markBestAnswer(Answer $answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }

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
