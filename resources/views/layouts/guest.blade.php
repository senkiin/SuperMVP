<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ElevateAi Business') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            /* Animaciones personalizadas */
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(-5deg); }
                66% { transform: translateY(-10px) rotate(5deg); }
            }

            @keyframes gradient {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.5); }
                50% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.8); }
            }

            @keyframes slide-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient 4s ease infinite;
            }
            .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
            .animate-slide-up { animation: slide-up 0.6s ease-out forwards; }

            /* Glassmorphism effect */
            .glass {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .glass-dark {
                background: rgba(17, 24, 39, 0.7);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="overflow-x-hidden">
        <div class="min-h-screen relative">
            <!-- Animated background -->
            <div class="fixed inset-0 overflow-hidden">
                <!-- Gradient background -->
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 animate-gradient"></div>

                <!-- Dark overlay for better contrast -->
                <div class="absolute inset-0 bg-black/20"></div>

                <!-- Animated shapes -->
                <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
                <div class="absolute top-40 right-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
                <div class="absolute bottom-20 left-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 4s;"></div>

                <!-- Grid pattern -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 font-sans text-gray-900 dark:text-gray-100 antialiased">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts

        <script>
            // Parallax effect on mouse move
            document.addEventListener('mousemove', (e) => {
                const shapes = document.querySelectorAll('.animate-float');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                shapes.forEach((shape, index) => {
                    const speed = (index + 1) * 20;
                    shape.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });
            });
        </script>
    </body>
</html>
