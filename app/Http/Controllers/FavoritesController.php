<?php

namespace App\Http\Controllers;

use App\Notifications\NewFavoriteAdded;
use App\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Question $question ){
        $question->favorites()->attach(auth()->id());
        $question->owner->notify(new NewFavoriteAdded($question));
        return redirect()->back();
    }
    public function destroy(Question $question ){
        $question->favorites()->detach(auth()->id());
        return redirect()->back();
    }
}
