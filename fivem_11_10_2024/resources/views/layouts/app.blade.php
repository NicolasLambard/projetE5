<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Styles globaux */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Arial', sans-serif;
            }
            
            html, body {
                height: 100%;
                margin: 0;
                background-color: #f5f5f5;
                color: #333;
            }
            
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
            
            /* Header et Navigation */
            header {
                background-color: #333;
                color: white;
                padding: 0;
            }
            
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 60px;
            }
            
            .logo {
                font-weight: bold;
                font-size: 1.5rem;
                padding-left: 20px;
            }
            
            .nav-links {
                display: flex;
                justify-content: center;
                flex-grow: 1;
            }
            
            .nav-links a {
                color: white;
                text-decoration: none;
                padding: 0 15px;
                font-weight: 500;
                transition: color 0.3s;
            }
            
            .nav-links a:hover {
                color: #3498db;
            }
            
            .logout-btn {
                padding-right: 20px;
            }
            
            .logout-btn button {
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                font-weight: 500;
                transition: color 0.3s;
            }
            
            .logout-btn button:hover {
                color: #3498db;
            }
            
            /* Footer */
            footer {
                background-color: #333;
                color: white;
                text-align: center;
                padding: 1.5rem 0;
                margin-top: auto;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <header>
                <div class="navbar">
                    <div class="logo">ShadyCorp</div>
                    <div class="nav-links">
                        <a href="{{ url('/') }}">Accueil</a>
                        <a href="{{ url('/demande') }}">Demande</a>
                        <a href="{{ url('/services') }}">Services</a>
                        <a href="{{ route('ticket') }}">Mes Tickets</a>
                        <a href="{{ route('commentaires') }}">Commentaires</a>
                        @if(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)
                            <a href="{{ route('ticket.all') }}">Voir tous les tickets</a>
                        @endif
                    </div>
                    <div class="logout-btn">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <footer>
                <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
            </footer>
        </div>
    </body>
</html>
