<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PINJAM') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            mix-blend-mode: multiply;
            animation: blob 7s infinite;
        }
        
        .blob-1 {
            top: 0;
            left: 0;
            width: 300px;
            height: 300px;
            background: rgba(59, 130, 246, 0.3);
            animation-delay: 0s;
        }
        
        .blob-2 {
            top: 50%;
            right: 0;
            width: 350px;
            height: 350px;
            background: rgba(139, 92, 246, 0.3);
            animation-delay: 2s;
        }
        
        .blob-3 {
            bottom: 0;
            left: 50%;
            width: 300px;
            height: 300px;
            background: rgba(236, 72, 153, 0.3);
            animation-delay: 4s;
        }
        
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800">
            <!-- Animated Blobs -->
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
            
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
                <!-- Logo/Icon -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-white bg-opacity-20 backdrop-blur-lg rounded-3xl flex items-center justify-center shadow-2xl">
                        <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>

                <!-- Title & Description -->
                <h1 class="text-5xl font-bold mb-4 text-center">PINJAM</h1>
                <p class="text-xl text-blue-100 mb-12 text-center max-w-md">
                    Sistem Peminjaman Alat yang Modern dan Efisien
                </p>

                <!-- Features -->
                <div class="space-y-6 max-w-md">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Mudah Digunakan</h3>
                            <p class="text-blue-100 text-sm">Interface yang intuitif dan user-friendly</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Aman & Terpercaya</h3>
                            <p class="text-blue-100 text-sm">Data Anda dijamin aman dan terenkripsi</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Cepat & Efisien</h3>
                            <p class="text-blue-100 text-sm">Proses peminjaman yang cepat dan praktis</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="mt-16 text-center">
                    <p class="text-blue-200 text-sm">
                        © {{ date('Y') }} PINJAM. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl items-center justify-center shadow-lg mb-4">
                        <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">PINJAM</h2>
                    <p class="text-gray-600 mt-1">Sistem Peminjaman Alat</p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>