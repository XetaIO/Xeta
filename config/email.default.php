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
            'className' => getenv('EMAIL_CLASSNAME') ? getenv('EMAIL_CLASSNAME') : 'Mail',
            // The following keys are used in SMTP transports
            'host' => getenv('EMAIL_HOST') ? getenv('EMAIL_HOST') : 'localhost',
            'port' => getenv('EMAIL_PORT') ? getenv('EMAIL_PORT') : 25,
            'timeout' => 30,
            'username' => getenv('EMAIL_USERNAME') ? getenv('EMAIL_USERNAME') : 'user',
            'password' => getenv('EMAIL_PASSWORD') ? getenv('EMAIL_PASSWORD') : 'secret',
            'client' => getenv('EMAIL_CLIENT') ? getenv('EMAIL_CLIENT') : null,
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
