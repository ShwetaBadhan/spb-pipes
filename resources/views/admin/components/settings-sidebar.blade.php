<div class="card settings-card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="sidebars settings-sidebar">
                                            <div class="sidebar-inner">
                                                <div class="sidebar-menu p-0">
                                                    <ul>
                                                        <li class="submenu-open">
                                                            <ul>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="{{ request()->routeIs('account-settings*', 'security-settings*', 'notifications-settings*', 'general-settings*') ? 'active subdrop' : '' }}">
                                                                        <i class="isax isax-setting-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('account-settings') }}" class="{{ request()->routeIs('account-settings*') ? 'active' : '' }}">Account Settings</a></li>
                                                                        <li><a href="{{ route('security-settings') }}" class="{{ request()->routeIs('security-settings*') ? 'active' : '' }}">Security</a></li>
                                                                        {{-- <li><a href="{{ route('plans-billings') }}">Plans & Billing</a></li> --}}
                                                                        <li><a href="{{ route('notifications-settings') }}" class="{{ request()->routeIs('notifications-settings*') ? 'active' : '' }}">Notifications</a></li>
                                                                        <li><a href="{{ route('tenant.billing') }}" class="{{ request()->routeIs('tenant.billing*') ? 'active' : '' }}">Plans & Billing</a></li>
                                                                        <li><a href="{{ route('general-settings') }}" class="{{ request()->routeIs('general-settings*') ? 'active' : '' }}">Integrations</a></li>
                                                                        {{-- <li><a href="{{ route('general-settings') }}">Captcha</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="{{ request()->routeIs('settings.system-settings*', 'localization-settings*', 'language-settings*', 'maintenance-mode*') ? 'active subdrop' : '' }}">
                                                                        <i class="isax isax-global fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('settings.system-settings') }}" class="{{ request()->routeIs('settings.system-settings*') ? 'active' : '' }}">Company Settings</a></li>
                                                                        <li><a href="{{ route('localization-settings') }}" class="{{ request()->routeIs('localization-settings*') ? 'active' : '' }}">Localization</a></li>
                                                                        {{-- <li><a href="{{ route('prefixes-settings') }}">Prefixes</a></li> --}}
                                                                        {{-- <li><a href="{{ route('preference-settings') }}">Preference</a></li> --}}
                                                                        {{-- <li><a href="{{ route('seo-setup') }}">SEO Setup</a></li> --}}
                                                                        <li><a href="{{ route('language-settings') }}" class="{{ request()->routeIs('language-settings*') ? 'active' : '' }}">Language</a></li>
                                                                        <li><a href="{{ route('maintenance-mode') }}" class="{{ request()->routeIs('maintenance-mode*') ? 'active' : '' }}">Maintenance Mode</a></li>
                                                                        <li><a href="{{ route('tenant.branding') }}" class="{{ request()->routeIs('tenant.branding*') ? 'active' : '' }}">Branding</a></li>
                                                                        {{-- <li><a href="{{ route('ai-configuration') }}">AI Configuration</a></li> --}}
                                                                        {{-- <li><a href="{{ route('appearance-settings') }}">Appearance</a></li> --}}
                                                                        {{-- <li><a href="{{ route('plugin-manager') }}">Plugin Manager</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="{{ request()->routeIs('invoice-settings*', 'invoice-templates-settings*') ? 'active subdrop' : '' }}">
                                                                        <i class="isax isax-shapes fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">App Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('invoice-settings') }}" class="{{ request()->routeIs('invoice-settings*') ? 'active' : '' }}">Invoice Settings</a></li>
                                                                        <li><a href="{{ route('invoice-templates-settings') }}" class="{{ request()->routeIs('invoice-templates-settings*') ? 'active' : '' }}">Invoice Templates</a></li>
                                                                        {{-- <li><a href="{{ route('esignatures') }}">eSignatures</a></li>
                                                                        <li><a href="{{ route('barcode-settings') }}">Barcode</a></li>
                                                                        <li><a href="{{ route('thermal-printer') }}">Thermal Printer</a></li>
                                                                        <li><a href="{{ route('custom-fields') }}">Custom Fields</a></li>
                                                                        <li><a href="{{ route('sass-settings') }}">SaaS Settings</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="{{ request()->routeIs('payment-methods*', 'bank-accounts*', 'tax-rates*', 'currencies*') ? 'active subdrop' : '' }}">
                                                                        <i class="isax isax-money-3 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Finance Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="{{ route('payment-methods') }}" class="{{ request()->routeIs('payment-methods*') ? 'active' : '' }}">Payment Methods</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('bank-accounts-settings') }}" class="{{ request()->routeIs('bank-accounts*') ? 'active' : '' }}">Bank Accounts</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('tax-rates') }}" class="{{ request()->routeIs('tax-rates*') ? 'active' : '' }}">Tax Rates</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('currencies') }}" class="{{ request()->routeIs('currencies*') ? 'active' : '' }}">Currencies</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="{{ request()->routeIs('email-settings*', 'email-templates*', 'gdpr-cookies*') ? 'active subdrop' : '' }}">
                                                                        <i class="isax isax-more-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">System Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('email-settings') }}" class="{{ request()->routeIs('email-settings*') ? 'active' : '' }}">Email Settings</a></li>
                                                                        <li><a href="{{ route('email-templates') }}" class="{{ request()->routeIs('email-templates*') ? 'active' : '' }}">Email Templates</a></li>
                                                                        {{-- <li><a href="{{ route('sms-gateways') }}">SMS Gateways</a></li> --}}
                                                                        <li><a href="{{ route('gdpr-cookies') }}" class="{{ request()->routeIs('gdpr-cookies*') ? 'active' : '' }}">GDPR Cookies</a></li>
                                                                    </ul>
                                                                </li>
                                                                {{-- <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-document fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Other Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="{{ route('custom-css') }}">Custom CSS</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('custom-js') }}">Custom JS</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('sitemap') }}">Sitemap</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('clear-cache') }}">Clear Cache</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('storage-settings') }}">Storage Settings</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('cronjob') }}">Cronjob</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('system-backup') }}">System Backup</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('database-backup') }}">Database Backup</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('system-update') }}">System Update</a>
                                                                        </li>
                                                                    </ul>
                                                                </li> --}}
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->