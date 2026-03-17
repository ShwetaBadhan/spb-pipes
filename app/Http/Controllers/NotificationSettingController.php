<?php
// app/Http/Controllers/NotificationSettingController.php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationSettingController extends Controller
{
    // Centralized notification structure
    private function getNotificationStructure()
    {
        return [
            'general' => [
                'label' => 'General Notifications',
                'icon' => 'isax-notification',
                'items' => [
                    ['key' => 'system_updates', 'label' => 'System Updates', 'desc' => 'Get alerts for software updates and maintenance.'],
                    ['key' => 'security_alerts', 'label' => 'Security Alerts', 'desc' => 'Notify about login attempts, password changes.'],
                ]
            ],
            'sales' => [
                'label' => 'Sales Notifications',
                'icon' => 'isax-shopping-cart',
                'items' => [
                    ['key' => 'new_sale', 'label' => 'New Sale Recorded', 'desc' => 'Get notified when a sale is made.'],
                    ['key' => 'pending_payments', 'label' => 'Pending Payments', 'desc' => 'Alerts for overdue invoices.'],
                    ['key' => 'transactions', 'label' => 'Transactions', 'desc' => 'Confirmation when a payment is received.'],
                ]
            ],
            'invoice' => [
                'label' => 'Invoice Notifications',
                'icon' => 'isax-notification-status',
                'items' => [
                    ['key' => 'new_invoice', 'label' => 'New Invoice Created', 'desc' => 'Alert when a new invoice is generated.'],
                    ['key' => 'invoice_due', 'label' => 'Invoice Due Reminder', 'desc' => 'Notification before the invoice due date.'],
                ]
            ],
            'user_management' => [
                'label' => 'User Management',
                'icon' => 'isax-user-tag',
                'items' => [
                    ['key' => 'new_user', 'label' => 'New User Added', 'desc' => 'Notify when a new user is registered.'],
                    ['key' => 'user_feedback', 'label' => 'User Feedback', 'desc' => 'Alerts for received feedback or reviews.'],
                    ['key' => 'role_changes', 'label' => 'Role & Permission Changes', 'desc' => 'Notify when user roles are updated.'],
                    ['key' => 'direct_messages', 'label' => 'Direct Messages & Mentions', 'desc' => 'Get alerts when you are tagged or messaged.'],
                ]
            ],
        ];
    }

    /**
     * Display notification settings page
     */
    public function index()
    {
        $user = Auth::user();
        $structure = $this->getNotificationStructure();
        
        // Fetch user's notification settings
        $settings = NotificationSetting::where('user_id', $user->id)
            ->get()
            ->groupBy('category');
        
        // Build data for view with defaults
        $notificationData = [];
        foreach ($structure as $categoryKey => $category) {
            $categorySettings = $settings->get($categoryKey, collect());
            
            $notificationData[$categoryKey] = [
                'label' => $category['label'],
                'icon' => $category['icon'],
                'is_category_enabled' => $categorySettings->first()?->is_category_enabled ?? true,
                'items' => collect($category['items'])->map(function($item) use ($categorySettings) {
                    $setting = $categorySettings->firstWhere('notification_key', $item['key']);
                    return [
                        'key' => $item['key'],
                        'label' => $item['label'],
                        'desc' => $item['desc'],
                        'channel_email' => $setting?->channel_email ?? true,
                        'channel_sms' => $setting?->channel_sms ?? false,
                        'channel_inapp' => $setting?->channel_inapp ?? true,
                        'channel_whatsapp' => $setting?->channel_whatsapp ?? false,
                    ];
                }),
            ];
        }
        
        return view('admin.pages.settings.general-settings.notifications-settings', 
            compact('notificationData'));
    }

    /**
     * Update notification settings - Update if exists, Create if not
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $structure = $this->getNotificationStructure();
        
        DB::beginTransaction();
        
        try {
            foreach ($structure as $categoryKey => $category) {
                // Get category-level toggle (defaults to true if not sent)
                $categoryEnabled = $request->boolean("category_{$categoryKey}_enabled", true);
                
                foreach ($category['items'] as $item) {
                    $notificationKey = $item['key'];
                    
                    $data = [
                        'is_category_enabled' => $categoryEnabled,
                        'channel_email' => $request->boolean("{$categoryKey}_{$notificationKey}_email", false),
                        'channel_sms' => $request->boolean("{$categoryKey}_{$notificationKey}_sms", false),
                        'channel_inapp' => $request->boolean("{$categoryKey}_{$notificationKey}_inapp", false),
                        'channel_whatsapp' => $request->boolean("{$categoryKey}_{$notificationKey}_whatsapp", false),
                    ];
                    
                    // ✅ LOGIC: Update if exists, Create if not
                    NotificationSetting::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'category' => $categoryKey,
                            'notification_key' => $notificationKey,
                        ],
                        $data
                    );
                }
            }
            
            DB::commit();
            return back()->with('success', 'Notification preferences saved successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Notification settings save failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to save notification settings. Please try again.');
        }
    }
}