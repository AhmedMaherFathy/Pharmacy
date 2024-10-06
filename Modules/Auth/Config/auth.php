<?php

return [
    'verify' => [
        'enabled' => env('VERIFY_ENABLED', false),
        'strategy' => env('VERIFY_STRATEGY', 'email'),
        'strategies' => [
            'email' => [
                'class' => \Modules\Auth\Strategies\EmailVerificationStrategy::class,
            ],
            'otp' => [
                'class' => \Modules\Auth\Strategies\OTPVerificationStrategy::class,
            ],
        ]
    ]
];
