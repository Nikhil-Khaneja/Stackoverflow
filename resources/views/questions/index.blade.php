@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                     <div class="d-flex justify-content-end mb-3">
                          <a href="{{ route('questions.create') }}" class="btn btn-outline-primary">Ask a Question!</a>
                     </div>
                <div class="card">
                    <div class="card-header">All Questions</div>
                    <div class="card-body">
                        @foreach ($questions as $question)
                            <div>
                                    <div class="media">
                                        <div class="d-flex flex-column statistics">
                                            <div class="votes text-center mb-3">
                                                <strong class="d-block ">{{ $question->votes_count }}</strong>
                                                Votes
                                            </div>

                                            <div class="answers text-center mb-3">
                                            <strong class="d-block answers {{ $question->answers_style }}">{{$question->answers_count}}</strong>
                                                Answers
                                            </div>

                                            <div class="votes text-center mb-3">
                                                <strong class="d-block  ">{{ $question->views_count }}</strong>
                                                Views
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="d-flex justify-content-between">
                                                <h4>
                                                    <a href="{{ $question->url }} "> {{ $question->title }}</a>
                                                </h4>
                                                <div class="d-flex">
                                                    {{-- @if (auth()->user() && auth()->user()->can('update_question', $question)) --}}
                                                    @can('update', $question)   
                                                        <div class="mr-2">
                                                            <a href="{{ route('questions.edit', $question->id)}} " class="btn btn-sm btn-outline-info">Edit</a>
                                                        </div>
                                                    @endcan   
                                                    {{-- @endif --}}
                                                    
                                                    {{-- @can('delete-question', $question) --}}
                                                    @can('delete', $question)
                                                        
                                                        <form action="{{  route('questions.destroy', $question->id)}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    @endcan
                                                    
                                                </div>
                                            </div>
                                            <p>
                                                Asked By: <a href="#"> {{ $question->owner->name }}</a>
                                                <span class="text-muted">| Asked: {{ $question->created_date}} </span>    
                                            </p>
                                            <p>{!!Str::limit($question->body, 250)!!}</p>
                                            {{-- strip_tags() - thus function wll remove all the tags from above stmt and run it as plain stmt --}}
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection









