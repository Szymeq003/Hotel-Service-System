@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zweryfikuj swój adres e-mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nowy link weryfikacyjny został wysłany na Twój adres e-mail.') }}
                        </div>
                    @endif

                    {{ __('Przed kontynuowaniem sprawdź swój e-mail, aby znaleźć link weryfikacyjny.') }}
                    {{ __('Jeśli nie otrzymałeś e-maila') }}, <a href="{{ route('verification.resend') }}">{{ __('kliknij tutaj, aby poprosić o nowy') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
