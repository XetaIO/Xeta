<?php
return [
/**
 * Connection information used by the ORM to connect
 * to your application's datastores.
 */
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => '__DATABASE_HOST__',
            'username' => '__DATABASE_USERNAME__',
            'password' => '__DATABASE_PASSWORD__',
            'database' => '__DATABASE_NAME__',
            'prefix' => false,
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,

            /*
            * Set identifier quoting to true if you are using reserved words or
            * special characters in your table or column names. Enabling this
            * setting will result in queries built using the Query Builder having
            * identifiers quoted when creating SQL. It should be noted that this
            * decreases performance because each query needs to be traversed and
            * manipulated before being executed.
            */
            'quoteIdentifiers' => false,

            /*
            * During development, if using MySQL < 5.6, uncommenting the
            * following line could boost the speed at which schema metadata is
            * fetched from the database. It can also be set directly with the
            * mysql configuration directive 'innodb_stats_on_metadata = 0'
            * which is the recommended value in production enviroments
            */
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => getenv('MYSQL_HOST') ? getenv('MYSQL_HOST') : 'localhost',
            //'port' => 'nonstandard_port_number',
            'username' => getenv('MYSQL_USER') ? getenv('MYSQL_USER') : 'root',
            'password' => getenv('MYSQL_PASSWORD') ? getenv('MYSQL_PASSWORD') : '',
            'database' => getenv('MYSQL_DATABASE') ? getenv('MYSQL_DATABASE') : 'test',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ]
    ]
];
