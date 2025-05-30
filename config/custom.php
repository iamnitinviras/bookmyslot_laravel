<?php
//Custom environment variable
return [
    'facebook_social_login' => env('FACEBOOK_SOCIAL_LOGIN', 'disable'),
    'google_social_login' => env('GOOGLE_SOCIAL_LOGIN', 'disable'),

    'facebook_client_id' => env('FACEBOOK_CLIENT_ID', ''),
    'facebook_client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
    'facebook_callback_url' => env('FACEBOOK_CALLBACK_URL', ''),

    'google_client_id' => env('GOOGLE_CLIENT_ID', ''),
    'google_client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
    'google_callback_url' => env('GOOGLE_CALLBACK_URL', ''),

    'enable_sign_up' => env('ENABLE_SIGNUP', 'enable'),
    'enable_blog' => env('ENABLE_BLOG', 'enable'),
    'enable_faq' => env('ENABLE_FAQ', 'enable'),
    'enable_testimonial' => env('ENABLE_TESTIMONIAL', 'enable'),
    'redirect_https' => env('REDIRECT_HTTPS', true),
    'facebook_url' => env('FACEBOOK_URL'),
    'instagram_url' => env('INSTAGRAM_URL'),
    'twitter_url' => env('TWITTER_URL'),
    'youtube_url' => env('YOUTUBE_URL'),
    'linkedin_url' => env('LINKEDIN_URL'),
    'support_email' => env('SUPPORT_EMAIL'),
    'support_phone' => env('SUPPORT_PHONE'),
    'per_page' => env('PER_PAGE', 15),

    'date_time_format' => env('APP_DATE_TIME_FORMAT', 'Y-m-d H:i:s'),
    'date_format' => env('APP_DATE_FORMAT', 'Y-m-d'),
    'time_format' => env('APP_TIME_FORMAT', 'H:i:s'),

    'currency' => env('APP_CURRENCY', 'USD'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '$'),
    'currency_position' => env('CURRENCY_POSITION', 'left'),

    'enable_captcha_on_suggestion' => (bool) env('ENABLE_CAPTCHA_ON_SUGGESTION', false),
    'enable_captcha_on_comments' => (bool) env('ENABLE_CAPTCHA_ON_COMMENTS', false),
    'enable_captcha_on_contact_us' => (bool) env('ENABLE_CAPTCHA_ON_CONTACT_US', false),
    'enable_captcha_on_support_request' => (bool) env('ENABLE_CAPTCHA_ON_SUPPORT_REQUEST', false),
    'enable_captcha' => (bool) env('ENABLE_CAPTCHA', false),
    'nocaptcha_secret' => env('NOCAPTCHA_SECRET', ''),
    'nocaptcha_sitekey' => env('NOCAPTCHA_SITEKEY', ''),

    'trial_days' => (int) env('TRIAL_DAYS', 14),
    'trial_member' => env('TRIAL_MEMBER', 5),
    'trial_branch' => env('TRIAL_BRANCH', 1),
    'trial_staff' => env('TRIAL_STAFF', 1),

    'logo' => env('APP_DARK_SMALL_LOGO', '/front-images/logo.png'),
    'favicon_icon' => env('APP_FAVICON_ICON', '/front-images/logo-light.png'),

    'banner_image_one' => env('BANNER_IMAGE_ONE', '/front-images/background.png'),
    'banner_image_two' => env('BANNER_IMAGE_TWO', '/front-images/auth-bg.png'),
];
