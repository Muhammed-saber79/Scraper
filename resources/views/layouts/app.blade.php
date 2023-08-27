<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }} | Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"></link>
        <link rel="stylesheet" href="{{ asset('assets/css/pagination.css') }}"></link>
        @livewireStyles

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200&family=Noto+Sans+Arabic:wght@500&family=Noto+Serif:ital,wght@0,300;1,300&family=Roboto&display=swap" rel="stylesheet">
    
        <!-- Font Awsome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    </head>
    <body>
        <nav class="navbar">
            <div class="container">
                <div class="brand">
                    <a href="{{ route('home') }}" wire:navigate style="text-decoration: none; color: #e6e6e6">Scraper</a>
                </div>
                <div class="links">
                    <ul>
                        <li>
                            <a href="{{ route('home') }}" wire:navigate>Home</a>
                        </li>
                        <li>
                            <a id="loadMore" href="{{ route('load_more') }}" wire:navigate>Load More</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="loader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <img src="{{ asset('assets/images/loader_old.gif') }}" alt="Loading...">
        </div>


        @yield('content')

        <script>
            var btn = document.getElementById('loadMore');
            var loader = document.getElementById('loader');
            var state = 'init';

            btn.addEventListener('click', function (event) {
                event.preventDefault();
                loader.style.display = 'block';

                fetch(btn.getAttribute('href'))
                    .then( () => {
                        console.log('Succeeded');
                        loader.style.display = 'none';
                        } )
                    .catch( () => console.log('Failed...!') )
            })
        </script>
        @livewireScripts
    </body>
</html>