<!-- Guest Footer -->
@php $platformName = \App\Models\CentralSetting::get('platform_name', 'SPB Pipes'); @endphp
<style>
    @import url('https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap');
    *{
        font-family: "Geist", sans-serif;
    }
    .footer-watermark{
        font-size: clamp(3rem, 15vw, 15rem);
        line-height: 0.7;
        font-weight: 800;
        color: transparent;
        -webkit-text-stroke: 1px #D4D4D4;
        text-align: center;
        margin-top: 1.5rem;
    }
</style>
<div class='bg-bl ack pt-20 px-4'>
    <footer class="bg-white container mx-auto text-black pt-8 lg:pt-12 px-4 sm:px-8 md:px-16 lg:px-28 rounded-tl-3xl rounded-tr-3xl overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-6 gap-8 md:gap-12">

            <div class="lg:col-span-3 space-y-6">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('assets/img/saas-default-logo.png') }}" width="150" alt="{{ $platformName }} Logo" class="h-10 w- auto">
                </a>
                <p class="text-sm/6 text-neutral-600 max-w-96">{{ $platformName }} helps pipe manufacturers run their entire business — orders, invoicing, inventory, production and reporting — in one secure platform.</p>
                <div class="flex gap-5 md:gap-6 order-1 md:order-2">
                    <!-- Twitter -->
                    <a href="#" class="text-neutral-600 hover:text-neutral-700">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z" />
                        </svg>
                    </a>
                    <!-- Github -->
                    <a href="#" class="text-neutral-600 hover:text-neutral-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/>
                        </svg>
                    </a>
                    <!-- Linkedin -->
                    <a href="#" class="text-neutral-600 hover:text-neutral-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                    <!-- Youtube -->
                    <a href="#" class="text-neutral-600 hover:text-neutral-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/>
                        </svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="text-neutral-600 hover:text-neutral-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 lg:gap-28 items-start">
                <!-- Platform -->
                <div>
                    <h3 class="font-medium text-sm mb-4">Platform</h3>
                    <ul class="space-y-3 text-sm text-neutral-800 ps-0">
                        <li><a href="#features" class="hover:text-neutral-700">Features</a></li>
                        <li><a href="#pricing" class="hover:text-neutral-700">Pricing</a></li>
                        <li><a href="#testimonials" class="hover:text-neutral-700">Testimonials</a></li>
                        <li><a href="#about" class="hover:text-neutral-700">About Us</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h3 class="font-medium text-sm mb-4">Account</h3>
                    <ul class="space-y-3 text-sm text-neutral-800 ps-0">
                        <li><a href="{{ route('central.login') }}" class="hover:text-neutral-700">Admin Login</a></li>
                        <li><a href="{{ route('central.register') }}" class="hover:text-neutral-700">Get Started</a></li>
                        <li><a href="{{ route('central.password.request') }}" class="hover:text-neutral-700">Forgot Password</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="col-span-2 md:col-span-1">
                    <h3 class="font-medium text-sm mb-4">Company</h3>
                    <ul class="space-y-3 text-sm text-neutral-800 ps-0">
                        <li class="flex items-center gap-2">
                            <a href="#" class="hover:text-neutral-700">Careers</a>
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-neutral-50 border border-neutral-400 text-neutral-700">HIRING</span>
                        </li>
                        <li><a href="mailto:support@spbpipes.com" class="hover:text-neutral-700">Contact Us</a></li>
                        <li><a href="#" class="hover:text-neutral-700">Privacy policy</a></li>
                        <li><a href="#" class="hover:text-neutral-700">Terms of service</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-12 pt-4 border-t border-neutral-300 flex justify-between items-center">
            <p class="text-neutral-600 text-sm">&copy; {{ date('Y') }} {{ $platformName }}</p>
            <p class='text-sm text-neutral-600'>All rights reserved.</p>
        </div>
        <div class="relative">
            <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-3xl h-full max-h-64 bg-slate-100 rounded-full blur-[100px] pointer-events-none"></div>
            <h1 class="footer-watermark">
                {{ strtoupper($platformName) }}
            </h1>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<!-- Guest Footer End -->
