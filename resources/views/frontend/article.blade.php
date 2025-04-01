@extends('layouts.frontend')

@section('content')
<div class="article-container">

    <h1 class="article-header">
        Artykuł 
        <small class="article-subheader">
            o: 
            <a href="{{ route('object', ['id' => $article->object->id]) }}" class="article-object-link">{{ $article->object->name }}</a>
        </small>
    </h1>
    <p class="article-content">{{ $article->content }}</p>

    <a class="btn btn-primary top-buffer collapse-toggle" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Artykuł polubiło 
        <span class="badge like-count">{{ $article->users->count() }}</span> użytkowników
    </a>

    <div class="collapse" id="collapseExample">
        <div class="well like-section">
            <ul class="list-inline user-list">
                @foreach($article->users as $user)
                <li class="user-list-item">
                    <a href="{{ route('person', ['id' => $user->id]) }}" class="user-link">
                        <img 
                            title="{{ $user->FullName }}" 
                            class="media-object user-avatar" 
                            width="50" 
                            height="50" 
                            src="{{ $user->photos->first()->path ?? $placeholder }}" 
                            alt="{{ $user->FullName }}">
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <h3 class="comments-header">Komentarze</h3>

    @foreach($article->comments as $comment)
    <div class="media comment-item">
        <div class="media-left media-top">
            <a href="{{ route('person', ['id' => $comment->user->id]) }}" class="comment-user-link">
                <img 
                    class="media-object comment-avatar" 
                    width="50" 
                    height="50" 
                    src="{{ $comment->user->photos->first()->path ?? $placeholder }}" 
                    alt="{{ $comment->user->FullName }}">
            </a>
        </div>
        <div class="media-body comment-body">
            {{ $comment->content }}
        </div>
    </div>
    @endforeach

    @auth
        @if($article->isLiked())
            <a href="{{ route('unlike', ['id' => $article->id, 'type' => 'App\Article']) }}" class="btn btn-primary btn-xs top-buffer like-toggle">
                Cofnij polubienie
            </a>
        @else
            <a href="{{ route('like', ['id' => $article->id, 'type' => 'App\Article']) }}" class="btn btn-primary btn-xs top-buffer like-toggle">
                Polub artykuł
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-xs top-buffer like-toggle">
            Zaloguj się, aby polubić artykuł
        </a>
    @endauth

    @auth
        <a class="btn btn-primary add-comment-btn" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
            Dodaj komentarz
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-xs top-buffer add-comment-btn">
            Zaloguj się, aby dodać komentarz
        </a>

    @endauth

    <div class="collapse" id="collapseExample2">
        <div class="well comment-form-wrapper">
            <form method="POST" action="{{ route('addComment', ['article_id' => $article->id, 'App\Article']) }}" class="form-horizontal comment-form">
                <fieldset>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label comment-label">Komentarz</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control comment-textarea" rows="3" id="textArea"></textarea>
                            <span class="help-block comment-help">Dodaj komentarz na temat tego artykułu.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary submit-comment-btn">Wyślij</button>
                        </div>
                    </div>
                </fieldset>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

</div>
@endsection
