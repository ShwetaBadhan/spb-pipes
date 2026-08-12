<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'category',
        'variables',
        'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get default email templates
     */
    public static function getDefaultTemplates()
    {
        return [
            [
                'name' => 'Welcome Email',
                'slug' => 'welcome_email',
                'subject' => 'Welcome to {Company Name}!',
                'body' => 'Hi {Customer Name},<br><br>Welcome to {Company Name}! We\'re thrilled to have you as part of our community...',
                'category' => 'transactional',
                'variables' => ['Customer Name', 'Company Name', 'Website URL'],
            ],
            [
                'name' => 'Booking Confirmation',
                'slug' => 'booking_confirmation',
                'subject' => 'Booking Confirmed - #{Booking Number}',
                'body' => 'Dear {Customer Name},<br><br>Your booking #{Booking Number} has been confirmed...',
                'category' => 'transactional',
                'variables' => ['Customer Name', 'Booking Number', 'Booking Date', 'Car Name', 'Pickup Location', 'Pickup Date', 'Rental Price'],
            ],
            [
                'name' => 'Booking Reminder',
                'slug' => 'booking_reminder',
                'subject' => 'Reminder: Your booking is coming up!',
                'body' => 'Hi {Customer Name},<br><br>This is a friendly reminder about your upcoming booking...',
                'category' => 'transactional',
                'variables' => ['Customer Name', 'Booking Number', 'Pickup Date', 'Pickup Location'],
            ],
            [
                'name' => 'Booking Cancellation',
                'slug' => 'booking_cancellation',
                'subject' => 'Booking Cancelled - #{Booking Number}',
                'body' => 'Dear {Customer Name},<br><br>Your booking #{Booking Number} has been cancelled...',
                'category' => 'transactional',
                'variables' => ['Customer Name', 'Booking Number', 'Cancellation Date', 'Refund Amount'],
            ],
            [
                'name' => 'Seasonal Promotions',
                'slug' => 'seasonal_promotions',
                'subject' => '🎉 Special Offer Just For You!',
                'body' => 'Hi {Customer Name},<br><br>We have an exclusive offer waiting for you...',
                'category' => 'marketing',
                'variables' => ['Customer Name', 'Discount Code', 'Offer Valid Until', 'Website URL'],
            ],
            [
                'name' => 'System Update',
                'slug' => 'system_update',
                'subject' => 'Important System Update',
                'body' => 'Dear User,<br><br>We wanted to inform you about an important system update...',
                'category' => 'system',
                'variables' => ['Company Name', 'Update Date', 'Support Email'],
            ],
        ];
    }

    /**
     * Initialize default templates
     */
    public static function initializeDefaults()
    {
        $defaults = self::getDefaultTemplates();
        
        foreach ($defaults as $template) {
            self::firstOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }

    /**
     * Render template with variables replaced
     */
    public function render(array $data = [])
    {
        $content = $this->body;
        $subject = $this->subject;
        
        foreach ($data as $key => $value) {
            $placeholder = '{' . $key . '}';
            $content = str_replace($placeholder, $value, $content);
            $subject = str_replace($placeholder, $value, $subject);
        }
        
        return ['subject' => $subject, 'body' => $content];
    }
}
