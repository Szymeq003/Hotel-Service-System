@extends('layouts.frontend')

@section('content')
<div class="container-fluid places">

    @if (session('norooms'))
    <p class="text-center red bolded">
        {{ session('norooms') }}
    </p>
    @endif
    
    <h1 class="text-center">Ciekawe miejsca</h1>

    @foreach($objects->chunk(4) as $chunked_object)
    <div class="row">
        @foreach($chunked_object as $object)
            <div class="col-md-3 col-sm-6">
                <div class="image-card">
                    <div class="image">
                    <img class="img-responsive" src="{{ $object->photos->first()->path }}" alt="{{ $object->name }}">
                    </div>
                    <div class="caption">
                        <h3>{{ $object->name }} <small>{{ $object->city->name }}</small></h3>
                        <p>{{ Str::limit($object->description, 100) }}</p>
                        <p><a href="{{ route('object', ['id' => $object->id]) }}" class="btn-details" role="button">Szczegóły</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="pagination-custom">
    {{ $objects->links() }}
</div>

</div>
@endsection


