<?php
return [
/**
 * Email configuration.
 *
 * You can configure email transports and email delivery profiles here.
 *
 * By defining transports separately from delivery profiles you can easily
 * re-use transport configuration across multiple profiles.
 *
 * You can specify multiple configurations for production, development and
 * testing.
 *
 * ### Configuring transports
 *
 * Each transport needs a `className`. Valid options are as follows:
 *
 *  Mail   - Send using PHP mail function
 *  Smtp   - Send using SMTP
 *  Debug  - Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to src/Network/Email.  Transports should be named
 * 'YourTransport.php', where 'Your' is the name of the transport.
 *
 * ### Configuring delivery profiles
 *
 * Delivery profiles allow you to predefine various properties about email
 * messages from your application and give the settings a name. This saves
 * duplication across your application and makes maintenance and development
 * easier. Each profile accepts a number of keys. See `Cake\Network\Email\Email`
 * for more information.
 */
    'EmailTransport' => [
        'default' => [
            'className' => isset($_ENV['EMAIL_CLASSNAME']) ? $_ENV['EMAIL_CLASSNAME'] : 'Mail',
            // The following keys are used in SMTP transports
            'host' => isset($_ENV['EMAIL_HOST']) ? $_ENV['EMAIL_HOST'] : '',
            'port' => isset($_ENV['EMAIL_PORT']) ? $_ENV['EMAIL_PORT'] : 25,
            'timeout' => 30,
            'username' => isset($_ENV['EMAIL_USERNAME']) ? $_ENV['EMAIL_USERNAME'] : '',
            'password' => isset($_ENV['EMAIL_PASSWORD']) ? $_ENV['EMAIL_PASSWORD'] : '',
            'client' => isset($_ENV['EMAIL_CLIENT']) ? $_ENV['EMAIL_CLIENT'] : 'xeta.io',
            'tls' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null)
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'no-reply@xeta.io',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
    ],
];
