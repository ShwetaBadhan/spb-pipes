<!-- Guest Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <a class="d-inline-block mb-3" href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/saas-default-logo.png') }}" width="150" alt="SPB Pipes Logo" height="40">
                </a>
                <p class="text-white-50 mb-0">Powerful SaaS platform for managing SPB Pipes operations, tenants, and central administration.</p>
            </div>
            <div class="col-6 col-lg-2 offset-lg-2 mb-4 mb-lg-0">
                <h6 class="fw-semibold mb-3 text-white">Quick Links</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#home" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none">Features</a></li>
                    <li><a href="#about" class="text-white-50 text-decoration-none">About</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2 mb-4 mb-lg-0">
                <h6 class="fw-semibold mb-3 text-white">Account</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('central.login') }}" class="text-white-50 text-decoration-none">Admin Login</a></li>
                    <li><a href="{{ route('central.password.request') }}" class="text-white-50 text-decoration-none">Forgot Password</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h6 class="fw-semibold mb-3 text-white">Contact</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="mailto:support@spbpipes.com" class="text-white-50 text-decoration-none">support@spbpipes.com</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container mt-4 pt-4 border-top border-secondary">
        <p class="text-white-50 mb-0">
            &copy; {{ date('Y') }}
            {{ \App\Models\CentralSetting::get('platform_name', 'SPB Pipes') }}
        </p>
    </div>
</footer>
<!-- Guest Footer End -->
