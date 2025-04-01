@extends('layouts.frontend')

@section('content')
<div class="container-fluid places">

    <h1 class="text-center">{{ $object->name }} obiekt <small>{{ $object->city->name }}</small></h1>

    <p class="object-description">{{ $object->description }}</p>

    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#gallery" data-toggle="tab" aria-expanded="true">Galeria zdjęć</a>
        </li>
        <li>
            <a href="#people" data-toggle="tab" aria-expanded="true">
                Lubią ten obiekt 
                <span class="badge">{{ $object->users->count() }}</span>
            </a>
        </li>
        <li>
            <a href="#adress" data-toggle="tab" aria-expanded="false">Adres</a>
        </li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="gallery">
            @foreach($object->photos->chunk(3) as $chunked_photos)
                <div class="row top-buffer">
                    @foreach($chunked_photos as $photo)
                        <div class="col-md-4">
                            <img class="img-responsive-ob" src="{{ $photo->path ?? $placeholder }}" alt="">
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="tab-pane fade" id="people">
            <ul class="list-inline">
                @foreach($object->users as $user)
                    <li>
                        <a href="{{ route('person',['id'=>$user->id]) }}">
                            <img 
                                title="{{ $user->FullName }}" 
                                class="media-object img-responsive" 
                                width="50" 
                                height="50" 
                                src="{{ $user->photos->first()->path ?? $placeholder }}" 
                                alt="...">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="tab-pane fade address-container" id="adress">
            <p>{{ $object->address->street }} {{ $object->address->number }}</p>
        </div>
    </div>

    <section>
        <h2 class="text-center">Pokoje w obiekcie</h2>
        @foreach($object->rooms->chunk(4) as $chunked_rooms)
            <div class="row">
                @foreach($chunked_rooms as $room)
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail">
                            <img class="img-responsive img-circle" src="{{ $room->photos->first()->path ?? $placeholder }}" alt="...">
                            <div class="caption">
                                <h3>Nr {{ $room->room_number }}</h3>
                                <p>{{ str_limit($room->description, 70) }}</p>
                                <p>
                                    <a href="{{ route('room', ['id' => $room->id]) }}" class="btn btn-primary" role="button">Szczegóły</a>
                                    <a href="{{ route('room', ['id' => $room->id]) }}#reservation" class="btn btn-success pull-right" role="button">Zarezerwuj</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </section>

    <section>
        <h2 class="green">Komentarze o obiekcie</h2>
        @foreach($object->comments as $comment)
            <div class="media">
                <div class="media-left media-top">
                    <a title="{{ $comment->user->FullName }}" href="{{ route('person', ['id' => $comment->user->id]) }}">
                        <img 
                            class="media-object" 
                            width="50" 
                            height="50" 
                            src="{{ $comment->user->photos->first()->path ?? $placeholder }}" 
                            alt="...">
                    </a>
                </div>
                <div class="media-body">
                    {{ $comment->content }}
                    <p></p>
                    {!! $comment->rating !!}
                </div>
            </div>
            <hr>
        @endforeach
    </section>

    <div class="comment-button-container">
        @auth
            <button 
                class="comment-button" 
                data-toggle="collapse" 
                data-target="#collapseExample" 
                aria-expanded="false" 
                aria-controls="collapseExample">
                Dodaj komentarz
            </button>
        @else
            <button class="comment-button login-button">
                <a href="{{ route('login') }}" class="login-link">Zaloguj się, aby dodać komentarz</a>
            </button>
        @endauth
    </div>

    <div class="collapse" id="collapseExample">
        <div class="well">
            <form 
                method="POST" 
                action="{{ route('addComment', ['object_id' => $object->id, 'App\TouristObject']) }}" 
                class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Komentarz</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Dodaj komentarz na temat tego obiektu.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label">Ocena</label>
                        <div class="col-lg-10">
                            <select name="rating" class="form-control" id="select">
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Wyślij</button>
                        </div>
                    </div>
                </fieldset>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    <section>
        <h2 class="red">Artykuły o obiekcie / okolicy</h2>
        @foreach($object->articles as $article)
            <div class="articles-list">
                <h4 class="top-buffer">{{ $article->title }}</h4>
                <p>
                    <b>{{ $article->user->FullName }}</b>
                    <i>{{ $article->created_at }}</i>
                </p>
                <p>{{ str_limit($article->content, 250) }}</p>
                <a href="{{ route('article', ['id' => $article->id]) }}">Więcej</a>
            </div>
        @endforeach
    </section>

    <div class="like-button-container">
        @auth
            @if($object->isLiked())
                <button 
                    class="btn-primary like-button" 
                    onclick="location.href='{{ route('unlike', ['id' => $object->id, 'type' => 'App\TouristObject']) }}'">
                    Cofnij polubienie tego obiektu
                </button>
            @else
                <button 
                    class="btn-primary like-button" 
                    onclick="location.href='{{ route('like', ['id' => $object->id, 'type' => 'App\TouristObject']) }}'">
                    Polub ten obiekt
                </button>
            @endif
        @else
            <button 
                class="btn-login like-button" 
                onclick="location.href='{{ route('login') }}'">
                Zaloguj się, aby polubić ten obiekt
            </button>
        @endauth
    </div>

</div>
@endsection
