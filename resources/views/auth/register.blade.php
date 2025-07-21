<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-md w-full space-y-8 animate-slide-up">
            <!-- Logo -->
            <div class="text-center">
                <div class="mx-auto w-24 h-24 bg-white/10 backdrop-blur-lg rounded-3xl flex items-center justify-center transform hover:scale-110 transition-transform duration-300 animate-pulse-glow">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-4xl font-extrabold text-white">
                    Crea tu cuenta
                </h2>
                <p class="mt-2 text-sm text-gray-200">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="font-medium text-white hover:text-gray-100 underline underline-offset-4 transition-colors duration-200">
                        Inicia sesión
                    </a>
                </p>
            </div>

            <!-- Form Card -->
            <div class="glass-dark rounded-3xl shadow-2xl p-8 space-y-6">
                <x-validation-errors class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200" />

                <!-- Progress Steps -->
                <div class="flex items-center justify-center space-x-4 mb-8">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">1</div>
                        <span class="ml-2 text-sm text-gray-300">Cuenta</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 text-sm font-bold">2</div>
                        <span class="ml-2 text-sm text-gray-400">Verificar</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name Input -->
                    <div class="group">
                        <label for="name" class="block text-sm font-medium text-gray-200 mb-2 group-focus-within:text-white transition-colors">
                            {{ __('Nombre Completo') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-600 rounded-xl bg-gray-800/50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-gray-800/70"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-gray-200 mb-2 group-focus-within:text-white transition-colors">
                            {{ __('Dirección de Email') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-600 rounded-xl bg-gray-800/50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-gray-800/70"
                                placeholder="tu@ejemplo.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="group">
                        <label for="password" class="block text-sm font-medium text-gray-200 mb-2 group-focus-within:text-white transition-colors">
                            {{ __('Contraseña') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-600 rounded-xl bg-gray-800/50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-gray-800/70"
                                placeholder="••••••••">
                            <!-- Password strength indicator could be added here with JS -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <div class="flex space-x-1">
                                    <div class="w-1 h-4 bg-gray-600 rounded-full"></div>
                                    <div class="w-1 h-4 bg-gray-600 rounded-full"></div>
                                    <div class="w-1 h-4 bg-gray-600 rounded-full"></div>
                                    <div class="w-1 h-4 bg-gray-600 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Debe tener al menos 8 caracteres</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="group">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-2 group-focus-within:text-white transition-colors">
                            {{ __('Confirmar Contraseña') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-600 rounded-xl bg-gray-800/50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-gray-800/70"
                                placeholder="••••••••">
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <!-- Terms and Privacy -->
                        <div class="space-y-3 pt-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 rounded bg-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="text-gray-300">
                                        Acepto los
                                        <a href="{{ route('terms.show') }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 underline transition-colors">
                                            Términos de Servicio
                                        </a>
                                        y la
                                        <a href="{{ route('policy.show') }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 underline transition-colors">
                                            Política de Privacidad
                                        </a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            {{ __('Crear Cuenta') }}
                        </button>
                    </div>

                    <!-- Benefits -->
                    <div class="mt-6 p-4 bg-indigo-500/10 border border-indigo-500/30 rounded-xl">
                        <h3 class="text-sm font-medium text-white mb-2">🎉 Lo que obtendrás:</h3>
                        <ul class="space-y-1 text-xs text-gray-300">
                            <li class="flex items-center">
                                <svg class="w-3 h-3 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Búsquedas ilimitadas durante la beta
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Campañas de email con IA
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Soporte prioritario y acceso anticipado
                            </li>
                        </ul>
                    </div>
                </form>
            </div>

            <!-- Trust badges -->
            <div class="text-center text-xs text-gray-400 space-y-2">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>SSL Seguro</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Cumple con GDPR</span>
                    </div>
                </div>
                <p>Únete a más de 1,000 empresas que ya usan Elevate Business</p>
            </div>
        </div>
    </div>
</x-guest-layout>
