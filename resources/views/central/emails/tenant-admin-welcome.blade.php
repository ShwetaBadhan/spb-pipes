<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9;padding:24px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background:#0d6efd;padding:24px 32px;">
                            <h2 style="margin:0;color:#ffffff;font-size:20px;">Welcome to {{ $tenantName }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;color:#374151;font-size:15px;">Hi {{ $email }},</p>
                            <p style="margin:0 0 16px;color:#374151;font-size:15px;">
                                Your organization <strong>{{ $tenantName }}</strong> has been provisioned on our platform.
                                Your admin account is ready.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:6px;padding:16px;margin:0 0 16px;">
                                <tr>
                                    <td style="padding:6px 16px;color:#6b7280;font-size:13px;">Tenant URL</td>
                                    <td style="padding:6px 16px;color:#111827;font-size:14px;font-weight:600;">{{ $tenantDomain }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 16px;color:#6b7280;font-size:13px;">Login URL</td>
                                    <td style="padding:6px 16px;color:#111827;font-size:14px;font-weight:600;">{{ $loginUrl }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 16px;color:#6b7280;font-size:13px;">Email</td>
                                    <td style="padding:6px 16px;color:#111827;font-size:14px;font-weight:600;">{{ $email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 16px;color:#6b7280;font-size:13px;">Password</td>
                                    <td style="padding:6px 16px;color:#111827;font-size:14px;font-weight:600;">{{ $password }}</td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;color:#374151;font-size:15px;">Please sign in and change your password.</p>

                            <a href="{{ $loginUrl }}" style="display:inline-block;background:#0d6efd;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;">Sign In</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px;background:#f8fafc;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;color:#9ca3af;font-size:12px;">&copy; {{ date('Y') }} SPB Pipes SaaS. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
