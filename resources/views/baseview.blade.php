<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather & News</title>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
    <!-- Hover.css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" integrity="sha512-csw0Ma4oXCAgd/d4nTcpoEoz4nYvvnk21a8VA2h2dzhPAvjbUIK6V3si7/g/HehwdunqqW18RwCJKpD7rL67Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Script -->
    <script src="{{ url('js/main.js') }}"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Welcome!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="homepage" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="https://openweathermap.org/">OpenWeather API</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="https://www.openstreetmap.org/#map=5/38.007/-95.844" tabindex="-1">OpenStreetMap</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Weather For..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
        </nav>
        <div class="title d-flex justify-content-center align-items-center">
            <h1>Ready for Weather?</h1>
        </div>
    </header>
    <main>
        <section class="weather-section d-flex">
            <div class="weather-content d-flex flex-column justify-content-start align-items-center">
                        <h4 class="p-4">
                            {!! $location ?? 'Invalid City Name' !!}
                        </h4>
                <ul class="list-group">
                    @foreach($weather_data ?? [] as $item)
                            <li class="list-group-item">{{ $item ?? 'Null' }}</li>
                    @endforeach
                </ul>
            </div>
                <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=
                {{ $lon }} 
                %2C{{ $lat }}
                %2C{{ $lon }} 
                %2C{{ $lat }} 
                &amp;layer=mapnik"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=7/40.250/-76.250"></a></small>
            <!-- <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=-135.17578125000003%2C19.559790136497412%2C-67.41210937500001%2C52.77618568896171&amp;layer=mapnik" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=7/40.250/-76.250"></a></small> -->
        </section>
        <section class="divider">
            <div class="divider-box"></div>
            <div class="divider-box"></div>
            <div class="divider-box"></div>
        </section>
        <section class="container-fluid containers">
            <div class="row d-flex justify-content-around">
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name1'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title1'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image1'] ?? 'Null' }}" alt="News Image"></img>
                </div>
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name2'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title2'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image2'] ?? 'Null' }}" alt="News Image"></img>
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name3'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title3'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image3'] ?? 'Null' }}" alt="News Image"></img>
                </div>
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name4'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title4'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image4'] ?? 'Null' }}" alt="News Image"></img>
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name5'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title5'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image5'] ?? 'Null' }}" alt="News Image"></img>
                </div>
                <div class="col-10 col-sm-5 col-lg-4 news d-flex flex-column">
                    <header>
                        <h3>{{ $news_data['name6'] ?? 'Invalid Country' }}</h3>
                    </header>
                    <p>{{ $news_data['title6'] ?? 'Null' }}</p>
                    <img src="{{ $news_data['image6'] ?? 'Null' }}" alt="News Image"></img>
                </div>
            </div>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>