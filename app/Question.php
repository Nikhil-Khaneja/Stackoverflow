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

    /**
     * HELPER FUNCTION
     */
    public function markBestAnswer(Answer $answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}
