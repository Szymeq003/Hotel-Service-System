<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Ciesz się podróżą!</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://bootswatch.com/3/readable/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script>
        var base_url = '{{ url('/') }}';
        </script>
        
    </head>
    <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container1">
        <div class="navbar-header">
            <button type="button-home" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand home-link" href="{{ route('home') }}">Strona główna</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            @auth
            <ul class="nav navbar-nav">
                <li><p class="navbar-text">Witaj!</p></li>
                <li><p class="navbar-text user-name">{{ Auth::user()->name }}</p></li>
                <li><a href="{{ route('adminHome') }}" class="admin-link">Panel Rezerwacji</a></li>
                <li>
                    <a class="logout-button" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Wyloguj
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
            @endauth
            @guest
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('login') }}" class="login-alt-btn">Zaloguj się</a></li>
                <li><a href="{{ route('register') }}" class="register-alt-btn">Zarejestruj się</a></li>
            </ul>
            @endguest
        </div>
    </div>
</nav>



        <div class="jumbotron">
            <div class="container">
                <h1>Ciesz się podróżą!</h1>
                <p>Platforma dla turystów i właścicieli obiektów turystycznych. Znajdź oryginalne miejsce na wakacje!</p>
                <p>Zamieść pokój na stronie i pozwól aby odwiedzili cię turyści!</p>
                <form method="POST" <?php ?> action="{{ route('roomSearch') }}" class="form-inline">
                    <div class="form-group">
                        <label class="sr-only" for="city">Miasto</label>
                        <input name="city" value="{{ old('city') }}" type="text" class="form-control autocomplete" id="city" placeholder="Miejscowość">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="day_in">Zameldowanie</label>
                        <input name="check_in" value="{{ old('check_in') }}" type="text" class="form-control datepicker" id="check_in" placeholder="Data zameldowania">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="day_out">Wymeldowanie</label>
                        <input name="check_out" value="{{ old('check_out') }}" type="text" class="form-control datepicker" id="check_out" placeholder="Data wymeldowania">
                    </div>
                    <div class="form-group">
                    <select name="room_size" class="form-control">
                            <option>Osób w pokoju</option>
                            
                            @for($i=1;$i<=5;$i++)
                                @if( old('room_size') == $i )
                                <option selected value="{{$i}}">{{$i}}</option>
                                @else
                                <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                            
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning">Szukaj</button>
                       
                    {{ csrf_field() }}
                
                </form>

            </div>
        </div>

        @yield('content')

        <div class="container-fluid ">
    <div class="row mobile-apps justify-content-center align-items-center">
        <div class="col-md-6 col-xs-12">
            <div class="app-details">
                <h1 class="text-mobile">Pobierz aplikację mobilną.</h1>
                <div class="store-images-wrapper">
                    <a href="#"><img class="store-image" src="{{ asset('images/google.png') }}" alt="Google Play"></a>
                    <a href="#"><img class="store-image" src="{{ asset('images/apple.png') }}" alt="App Store"></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
        <footer class="footer">
            <div class="container-footer">
                <p class="text-muted">Ciesz się podróżą! &copy; 2025</p>
            </div>
        </footer>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/datepicker-pl.js') }}"></script>
        @stack('scripts')
    </body>
</html>