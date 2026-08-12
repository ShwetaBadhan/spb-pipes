<!-- Central Admin Footer -->
<div class="footer d-sm-flex align-items-center justify-content-between bg-white py-2 px-4 border-top">
    <p class="text-dark mb-0">
        &copy; {{ date('Y') }}
        <a href="javascript:void(0);" class="link-primary">{{ \App\Models\CentralSetting::get('platform_name', 'SPB Pipes SaaS') }}</a>
        | Central Admin Panel
    </p>
</div>
<!-- Footer End -->
