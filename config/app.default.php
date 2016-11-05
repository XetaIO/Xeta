<?php
return [
/**
 * Debug Level:
 *
 * Production Mode:
 * false: No error messages, errors, or warnings shown.
 *
 * Development Mode:
 * true: Errors and warnings shown.
 */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

/**
 * Configure basic information about the application.
 *
 * - namespace - The namespace to find app classes under.
 * - encoding - The encoding used for HTML + database connections.
 * - base - The base directory the app resides in. If false this
 *   will be auto detected.
 * - dir - Name of app directory.
 * - webroot - The webroot directory.
 * - www_root - The file path to webroot.
 * - baseUrl - To configure CakePHP to *not* use mod_rewrite and to
 *   use CakePHP pretty URLs, remove these .htaccess
 *   files:
 *      /.htaccess
 *      /webroot/.htaccess
 *   And uncomment the baseUrl key below.
 * - imageBaseUrl - Web path to the public images directory under webroot.
 * - cssBaseUrl - Web path to the public css directory under webroot.
 * - jsBaseUrl - Web path to the public js directory under webroot.
 * - paths - Configure paths for non class based resources. Supports the
 *   `plugins` and `templates` subkeys, which allow the definition of paths for
 *   plugins and view templates respectively.
 */
    'App' => [
        'namespace' => 'App',
        'encoding' => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'fr_FR'),
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        // 'baseUrl' => env('SCRIPT_NAME'),
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS],
            'locales' => [APP . 'Locale' . DS],
        ]
    ],

/**
 * Security and encryption configuration
 *
 * - salt - A random string used in security hashing methods.
 *   The salt value is also used as the encryption key.
 *   You should treat it as extremely sensitive data.
 */
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
        //Used to encrypt data in database.
        'key' => env('SECURITY_KEY', '__KEY__')
    ],

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified.
 * This is useful for busting browser caches.
 *
 * Set to true to apply timestamps when debug is true. Set to 'force' to always
 * enable timestamping regardless of debug value.
 */
    'Asset' => [
        // 'timestamp' => true,
    ],

/**
* Acl configuration.
*/
    'Acl' => [
        'classname' => 'CachedDbAcl',
        'cacheConfig' => 'acl'
    ],

/**
 * Configure the cache adapters.
 */
    'Cache' => [
        'default' => [
            'className' => 'File',
            'path' => CACHE,
            'url' => env('CACHE_DEFAULT_URL', null)
        ],

    /**
     * Configure the cache used for storing the acl request.
     */
        'acl' => [
            'className' => 'File',
            'prefix' => 'Xeta_acl_',
            'path' => CACHE . 'acl/',
            'duration' => '+1 days',
        ],

    /**
     * Configure the cache used for storing the statistics request.
     */
        'statistics' => [
            'className' => 'File',
            'prefix' => 'Xeta_statistics_',
            'path' => CACHE . 'statistics/',
            'duration' => '+1 days',
        ],

    /**
     * Configure the cache used for storing the request on Google Analytics.
     */
        'analytics' => [
            'className' => 'File',
            'prefix' => 'Xeta_analytics_',
            'path' => CACHE . 'views/',
            'duration' => '+1 hours',
        ],

    /**
     * Configure the cache used for short caching.
     */
        'short' => [
            'className' => 'File',
            'prefix' => 'Xeta_short_',
            'path' => CACHE . 'views/',
            'duration' => '+1 hours',
        ],

    /**
     * Configure the cache used for the database query caching.
     */
        'database' => [
            'className' => 'File',
            'prefix' => 'Xeta_database_',
            'path' => CACHE . 'database/',
            'duration' => '+1 days',
        ],

    /**
     * Configure the cache used for general framework caching. Path information,
     * object listings, and translation cache files are stored with this
     * configuration.
     */
        '_cake_core_' => [
            'className' => 'File',
            'prefix' => 'Xeta_core_',
            'path' => CACHE . 'persistent/',
            'serialize' => true,
            'duration' => '+2 minutes',
            'url' => env('CACHE_CAKECORE_URL', null)
        ],

    /**
     * Configure the cache for model and datasource caches. This cache
     * configuration is used to store schema descriptions, and table listings
     * in connections.
     */
        '_cake_model_' => [
            'className' => 'File',
            'prefix' => 'Xeta_model_',
            'path' => CACHE . 'models/',
            'serialize' => true,
            'duration' => '+2 minutes',
            'url' => env('CACHE_CAKEMODEL_URL', null)
        ],
    ],

/**
 * Configure the Error and Exception handlers used by your application.
 *
 * By default errors are displayed using Debugger, when debug is true and logged
 * by Cake\Log\Log when debug is false.
 *
 * In CLI environments exceptions will be printed to stderr with a backtrace.
 * In web environments an HTML page will be displayed for the exception.
 * With debug true, framework errors like Missing Controller will be displayed.
 * When debug is false, framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `errorLevel` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Whether or not backtraces should be included in
 *   logged errors/exceptions.
 * - `log` - boolean - Whether or not you want exceptions logged.
 * - `exceptionRenderer` - string - The class responsible for rendering
 *   uncaught exceptions.  If you choose a custom class you should place
 *   the file for that class in src/Lib/Error. This class needs to implement a
 *   render method.
 * - `skipLog` - array - List of exceptions to skip for logging. Exceptions that
 *   extend one of the listed exceptions will also be skipped for logging.
 *   E.g.: `'skipLog' => ['Cake\Error\NotFoundException', 'Cake\Error\UnauthorizedException']`
 */
    'Error' => [
        'errorLevel' => E_ALL,
        'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
        'skipLog' => [],
        'log' => true,
        'trace' => true,
    ],

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

/**
 * Configures logging options
 */
    'Log' => [
        'debug' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => LOGS,
            'file' => 'debug',
            'levels' => ['notice', 'info', 'debug'],
            'url' => env('LOG_DEBUG_URL', null),
        ],
        'error' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => LOGS,
            'file' => 'error',
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
            'url' => env('LOG_ERROR_URL', null),
        ],
    ],

/**
 *
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The
 * `defaults` key is used to define a default preset to use for sessions, any
 * settings declared here will override the settings of the default config.
 *
 * ## Options
 *
 * - `cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'.
 * - `cookiePath` - The url path for which session cookie is set. Maps to the
 *   `session.cookie_path` php.ini config. Defaults to base path of app.
 * - `timeout` - The number of minutes you want sessions to live for. This
 *    timeout is handled by CakePHP.
 *    value to false, when dealing with older versions of IE, Chrome Frame or
 *    certain web-browsing devices and AJAX.
 * - `defaults` - The default configuration set to use as a basis for your session.
 *    There are four built-in options: php, cake, cache, database.
 * - `handler` - Can be used to enable a custom session handler. Expects an
 *    array with at least the `engine` key, being the name of the Session engine
 *    class to use for managing the session. CakePHP bundles the `CacheSession`
 *    and `DatabaseSession` engines.
 * - `ini` - An associative array of additional ini values to set.
 *
 * The built-in `defaults` options are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at src/Network/Session/<name>.php.
 * Make sure the class implements PHP's `SessionHandlerInterface` and set
 * Session.handler to <name>
 *
 * To use database sessions, load the SQL file located at config/Schema/sessions.sql
 */
    'Session' => [
        'defaults' => 'database',
        'cookie' => 'Xeta',
        'handler' => [
            'model' => 'Sessions',
            'timeoutOnline' => 5
        ],
        'timeout' => 160
    ],

/**
 * Google Analytics configuration.
 *
 * More information on how to configure : https://github.com/widop/google-analytics/blob/master/doc/usage.md
 */
    'Analytics' => [
        'enabled' => false,

        /**
         * A \DateTime used to set since when we should get the information.
         *
         * Exemple format :
         * - 'Y-m-d' : 2014-08-01
         *
         * More information : http://php.net/manual/fr/datetime.construct.php
         */
        'start_date' => '',
        'client_id' => '',
        'profile_id' => '',
        'private_key' => ''
    ]
];
