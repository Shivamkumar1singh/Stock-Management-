<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stock Management') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* body {
            padding-top:30px;
        } */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: #1f2937;
            position: fixed;
            top: 56px; 
            left: 0;
            padding-top: 10px;
            transition: transform 0.3s ease-in-out;
            z-index: 1050;
        }

        .sidebar a { 
            display: block;
            color: #cbd5e1;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }

        .content{
            margin-left: 220px;
            padding: 20px;
            padding-top: 76px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                @auth
                <button class="btn btn-outline-secondary d-md-none me-2" onclick="toggleSidebar()" type="button"><span class="navbar-toggler-icon"></span></button>
                @endauth
                <a class="navbar-brand mb-0" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                </div>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                         
                    </ul>

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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                <!-- </div> -->
            </div>
        </nav>

        <!-- sidebar -->
         @auth 
             <div class="sidebar" id="sidebar">
                <a href="{{ route('home') }}">Dashboard</a>
                <a href="{{ route('product.index') }}">Products</a>
                <a href="{{ route('category.index') }}">Categories</a>
                <a href="{{ route('setting.edit')}}" >Settings</a>
             </div>
        @endauth

        <main class="@auth content @else py-4 pt-5 @endauth">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }
    </script>

</body>
</html>
