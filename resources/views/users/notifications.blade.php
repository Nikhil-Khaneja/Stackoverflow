@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Notifications</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item">
                                    @if ($notification->type === 'App\Notifications\NewReplyAdded')
                                        A new Reply was posted in your question 
                                        <strong>{{ $notification->data['question']['title'] }} </strong>
                                        <a href="{{ route('questions.show', $notification->data['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Question</a>
                                
                                    @elseif ($notification->type === 'App\Notifications\QuestionUpdated')
                                        Question has been updated
                                        <strong>{{ $notification->data['question']['title'] }} </strong>
                                        <a href="{{ route('questions.show', $notification->data['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Question</a>

                                    @elseif ($notification->type === 'App\Notifications\NewFavoriteAdded')
                                        New Favorite has been added to Question 
                                        <strong>{{ $notification->data['question']['title'] }} </strong>
                                        <a href="{{ route('questions.show', $notification->data['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Question</a>
                                    
                                    @elseif ($notification->type === 'App\Notifications\VoteQuestionNotification')
                                        Your vote has been updated 
                                        <strong>{{ $notification->data['question']['title'] }} </strong>
                                        <a href="{{ route('questions.show', $notification->data['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Question</a>
                                        
                                    @elseif ($notification->type === 'App\Notifications\ChangesUpdated')
                                        Answer has been updated in 
                                        {{-- {{ dd($notification->data)}} --}}
                                        <strong>{!! $notification->data['answer']['body'] !!} </strong>
                                        <a href="{{ route('questions.show', $notification->data['answer']['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Answer</a>
                                    
                                    @elseif ($notification->type === 'App\Notifications\BestAnswerMarked')
                                        Your Answer is marked as Best Answer
                                        <strong>{!! $notification->data['answer']['body'] !!} </strong>
                                        <a href="{{ route('questions.show', $notification->data['answer']['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Answer</a>
                                    
                                    @elseif ($notification->type === 'App\Notifications\VoteAnswerNotification')
                                        your voted has been updated   
                                        <strong>{!! $notification->data['answer']['title'] !!} </strong>
                                        <a href="{{ route('answers.questions.show', $notification->data['answer']['question']['slug'])}}" class="float-right btn btn-sm btn-info text-white">View Answer</a>
                                        
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection