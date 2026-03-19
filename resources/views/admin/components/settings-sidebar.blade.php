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
                                                                    <a href="javascript:void(0);" class="active subdrop">
                                                                        <i class="isax isax-setting-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('account-settings') }}" class="active">Account Settings</a></li>
                                                                        <li><a href="{{ route('security-settings') }}">Security</a></li>
                                                                        {{-- <li><a href="{{ route('plans-billings') }}">Plans & Billing</a></li> --}}
                                                                        <li><a href="{{ route('notifications-settings') }}">Notifications</a></li>
                                                                        <li><a href="{{ route('general-settings') }}">Integrations</a></li>
                                                                        {{-- <li><a href="{{ route('general-settings') }}">Captcha</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-global fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('settings.system-settings') }}">Company Settings</a></li>
                                                                        <li><a href="{{ route('localization-settings') }}">Localization</a></li>
                                                                        {{-- <li><a href="{{ route('prefixes-settings') }}">Prefixes</a></li> --}}
                                                                        {{-- <li><a href="{{ route('preference-settings') }}">Preference</a></li> --}}
                                                                        {{-- <li><a href="{{ route('seo-setup') }}">SEO Setup</a></li> --}}
                                                                        <li><a href="{{ route('language-settings') }}">Language</a></li>
                                                                        <li><a href="{{ route('maintenance-mode') }}">Maintenance Mode</a></li>
                                                                        {{-- <li><a href="{{ route('authentication-settings') }}">Authentication</a></li> --}}
                                                                        {{-- <li><a href="{{ route('ai-configuration') }}">AI Configuration</a></li> --}}
                                                                        {{-- <li><a href="{{ route('appearance-settings') }}">Appearance</a></li> --}}
                                                                        {{-- <li><a href="{{ route('plugin-manager') }}">Plugin Manager</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-shapes fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">App Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('invoice-settings') }}">Invoice Settings</a></li>
                                                                        <li><a href="{{ route('invoice-templates-settings') }}">Invoice Templates</a></li>
                                                                        {{-- <li><a href="{{ route('esignatures') }}">eSignatures</a></li>
                                                                        <li><a href="{{ route('barcode-settings') }}">Barcode</a></li>
                                                                        <li><a href="{{ route('thermal-printer') }}">Thermal Printer</a></li>
                                                                        <li><a href="{{ route('custom-fields') }}">Custom Fields</a></li>
                                                                        <li><a href="{{ route('sass-settings') }}">SaaS Settings</a></li> --}}
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-money-3 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Finance Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="{{ route('payment-methods') }}">Payment Methods</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('bank-accounts-settings') }}">Bank Accounts</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('tax-rates') }}">Tax Rates</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('currencies') }}">Currencies</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-more-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">System Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{ route('email-settings') }}">Email Settings</a></li>
                                                                        <li><a href="{{ route('email-templates') }}">Email Templates</a></li>
                                                                        {{-- <li><a href="{{ route('sms-gateways') }}">SMS Gateways</a></li> --}}
                                                                        <li><a href="{{ route('gdpr-cookies') }}">GDPR Cookies</a></li>
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