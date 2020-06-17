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

    public function setTitleAttribute($title){
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    } 
/*
    * Accesors - These are special functions which have getXXXAttribute()
    */
   public function getUrlAttribute(){
       return "questions/{$this->id}";
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
    /**
     * RELATIONSHIP METHODNJS
     */
    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
