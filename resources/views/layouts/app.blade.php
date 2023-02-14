<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title') </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- sweet alert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.4/sweetalert2.css"  />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.4/sweetalert2.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        {{-- home --}}
                            <li class="nav-item">
                                <a href="{{ route('index') }}" class="nav-link">
                                    <iconify-icon inline icon="clarity:house-solid" class="text-dark icon-sm"></iconify-icon>                                
                                </a>
                            </li>
                        {{-- create post  --}}
                            <li class="nav-item">
                                        {{-- ⬇️ 直接post.create に行くと category が generate されない・表示されないから /categories を経由して category を作成　--}}
                                <a href="/categories" class="nav-link">
                                    <iconify-icon inline icon="mdi:typewriter" class="text-dark icon-sm"></iconify-icon>
                                </a>
                            </li>
                        {{-- account --}}
                            <li class="nav-item dropdown">
                                <button id="navbarDropdown" class="nav-link btn shadown-none" href="#" role="button" data-bs-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset('storage/avatars/'. Auth::user()->avatar)}}" alt="{{ Auth::user()->avatar }}" class="rounded-circle avatar-sm ">
                                    @else
                                        <iconify-icon inline icon="mdi:user" class="text-dark icon-sm"></iconify-icon>                                    
                                    @endif
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        {{-- Admin --}}
                                    {{-- checks if the user is already logged in --}}
                                    {{-- check if the role id of the user is admin --}}
                                    @if (Auth::check() and Auth::user()->role_id == 1)
                                        <a href="{{ route('admin.users.index') }}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i>Admin
                                        </a>
                                    @endif
                        {{-- Profile --}}
                                    <a href="{{ route('profile.show', Auth::user()) }}" class="dropdown-item">
                                        <iconify-icon inline icon="mdi:user" class="text-dark"></iconify-icon> Profile
                                    </a>


                        {{-- Logout --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i>    {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                        {{-- admin controls --}}

                    {{-- request() : routeのため / is('admin/*') : admin と名のつく全てのroute--}}
                    {{-- ＝＝＝　route名に admin が入っている時、@if 内の code を実行 --}}
                    @if (request()->is('admin/*'))
                        <div class="col-3">
                            <div class="list-group">
                                <a href="{{ route('admin.users.index') }}" class="list-group-item">Users</a>
                                <a href="{{ route('admin.posts.index' )}}" class="list-group-item">Posts</a>
                                <a href="{{ route('admin.categories.index' )}}" class="list-group-item">Categories</a>
                            </div>
                        </div>
                    @endif

                    <div class="col-9">
                        @yield('content')
                    </div>

                </div>
            </div>
        </main>
    </div>
    <script src="https://code.iconify.design/iconify-icon/1.0.5/iconify-icon.min.js"></script>
</body>
</html>
