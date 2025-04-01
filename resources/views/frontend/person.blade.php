@extends('layouts.frontend')

@section('content')
<div class="custom-container horizontal-layout">
    <!-- User Image and Name -->
    <div class="custom-contener1">
        <div class="custom-image-container">
            <img src="{{ $user->photos->first()->path ?? $placeholder }}" alt="" class="img-circle img-responsive">
            <h2>{{ $user->FullName }}</h2>
        </div>
    </div>

    <!-- Liked Objects Section -->
    <div class="custom-contener1">
        <div class="section-header">Polubione obiekty</div>
        <div class="custom-button-wrapper">
            <button class="custom-liked-object"><span class="fa fa-plus-circle"></span> Polubionych obiektów {{ $user->objects->count() }}</button>
        </div>
        <ul class="custom-list-group">
            @foreach($user->objects as $object)
            <li class="custom-list-group-item">
                <a href="{{ route('object', ['id' => $object->id]) }}">{{ $object->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Liked Articles Section -->
    <div class="custom-contener1">
        <div class="section-header">Polubione artykuły</div>
        <div class="custom-button-wrapper">
            <button class="custom-liked-article"><span class="fa fa-user"></span> Polubionych artykułów {{ $user->larticles->count() }}</button>
        </div>
        <ul class="custom-list-group">
            @foreach($user->larticles as $article)
            <li class="custom-list-group-item">
                <a href="{{ route('article', ['id' => $article->id]) }}">{{ $article->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Comments Section -->
    <div class="custom-contener1">
        <div class="section-header">Komentarze</div>
        <div class="custom-button-wrapper">
            <button class="custom-comments"><span class="fa fa-gear"></span> Komentarzy {{ $user->comments->count() }}</button>
        </div>
        <ul class="custom-list-group">
            @foreach($user->comments as $comment)
            <li class="custom-list-group-item">
                {{ $comment->content }}
                <a href="{{ $comment->commentable->link }}">{{ $comment->commentable->type }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
