<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Tareas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="antialiased min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navbar -->
        <nav class="flex justify-between items-center py-6">
            <div class="text-2xl font-bold text-indigo-600">
                {{ config('app.name', 'Tareas en Equipo') }}
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('tareas.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Panel de Tareas
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-gray-600 hover:text-gray-900">
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-gray-900">
                        Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">
                    Sistema de Gestión de Tareas en Equipo
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Organiza, colabora y gestiona tus tareas académicas de manera eficiente con tu equipo.
                </p>
                
                <div class="flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('tareas.index') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-lg font-medium">
                            Ver Mis Tareas
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-lg font-medium">
                            Comenzar
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-50 text-lg font-medium">
                            Registrarse
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Features Section -->
            <div class="mt-16 grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Crea Tareas</h3>
                    <p class="text-gray-600">
                        Organiza tus actividades académicas con fechas límite y descripciones claras.
                    </p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Trabajo en Equipo</h3>
                    <p class="text-gray-600">
                        Invita compañeros a tus tareas y colaboren juntos en proyectos académicos.
                    </p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gestión de Archivos</h3>
                    <p class="text-gray-600">
                        Sube, comparte y organiza archivos relacionados con cada tarea.
                    </p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8 border-t border-gray-200 mt-12">
            <p class="text-center text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Sistema de Tareas') }}. Todos los derechos reservados.
            </p>
        </footer>
    </div>
</body>
</html>
