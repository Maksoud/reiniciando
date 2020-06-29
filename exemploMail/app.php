        'qtx' => [
            'className' => 'Smtp',
            // The following keys are used in SMTP transports
            'host' => 'ssl://smtp.gmail.com',
            'port' => 465,
            'timeout' => 30,
            'username' => 'workflow@qualitex.com.br',
            'password' => '',
            'client' => null,
            'tls' => null,
            'ssl' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ]
    ],