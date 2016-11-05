<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Composer\Script\Event;
use Exception;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     *
     * @return void
     */
    public static function postInstall(Event $event)
    {
        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));
        static::createAppConfig($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);
        static::createRecaptchaConfig($rootDir, $io);
        static::createDatabaseConfig($rootDir, $io);
        static::createEmailConfig($rootDir, $io);
        static::setDatabaseName($rootDir, $io);

        // ask if the permissions should be changed
        if ($io->isInteractive()) {
            $validator = function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }
                throw new Exception('This is not a valid answer. Please choose Y or n.');
            };
            $setFolderPermissions = $io->askAndValidate(
                '<info>Set Folder Permissions ? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                10,
                'Y'
            );

            if (in_array($setFolderPermissions, ['Y', 'y'])) {
                static::setFolderPermissions($rootDir, $io);
            }
        } else {
            static::setFolderPermissions($rootDir, $io);
        }

        $newKey = static::setSecuritySaltAndKey($rootDir, $io);
        static::setAccountPassword($rootDir, $io, $newKey);

        if (class_exists('\Cake\Codeception\Console\Installer')) {
            \Cake\Codeception\Console\Installer::customizeCodeceptionBinary($event);
        }
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function createAppConfig($dir, $io)
    {
        $appConfig = $dir . '/config/app.php';
        $defaultConfig = $dir . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $io->write('Created `config/app.php` file');
        }
    }

    /**
     * Create the config/database.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function createDatabaseConfig($dir, $io)
    {
        $databaseConfig = $dir . '/config/database.php';
        $defaultConfig = $dir . '/config/database.default.php';
        if (!file_exists($databaseConfig)) {
            copy($defaultConfig, $databaseConfig);
            $io->write('Created `config/database.php` file');
        }
    }

    /**
     * Create the config/email.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function createEmailConfig($dir, $io)
    {
        $databaseConfig = $dir . '/config/email.php';
        $defaultConfig = $dir . '/config/email.default.php';
        if (!file_exists($databaseConfig)) {
            copy($defaultConfig, $databaseConfig);
            $io->write('Created `config/email.php` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createWritableDirectories($dir, $io)
    {
        $paths = [
            'logs',
            'tmp',
            'tmp/cache',
            'tmp/cache/models',
            'tmp/cache/persistent',
            'tmp/cache/views',
            'tmp/sessions',
            'tmp/tests'
        ];

        foreach ($paths as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Create the config/recaptcha.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function createRecaptchaConfig($dir, $io)
    {
        $appConfig = $dir . '/config/recaptcha.php';
        $defaultConfig = $dir . '/config/recaptcha.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $io->write('Created `config/recaptcha.php` file');
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions($dir, $io)
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms, $io) {
            // Get permission bits from stat(2) result.
            $currentPerms = fileperms($path) & 0777;
            if (($currentPerms & $perms) == $perms) {
                return;
            }

            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms, $io) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path, $perms, $io);
                $walker($path, $perms, $io);
            }
        };

        $worldWritable = bindec('0000000111');
        $walker($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/logs', $worldWritable, $io);
    }

    /**
     * Set the datasources.default.database value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function setDatabaseName($dir, $io)
    {
        $config = $dir . '/config/database.php';
        $content = file_get_contents($config);

        $databaseName = $io->ask('What is the database host ? ', 'localhost');
        $content = str_replace('__DATABASE_HOST__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database name ? ', 'xeta_test');
        $content = str_replace('__DATABASE_NAME__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database username ? ', 'xeta');
        $content = str_replace('__DATABASE_USERNAME__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database password ? ', 'xeta');
        $content = str_replace('__DATABASE_PASSWORD__', $databaseName, $content, $count);

        if ($count == 0) {
            $io->write('No Datasources.default.database placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Datasources.default.database value in config/app.php');

            return;
        }
        $io->write('Unable to update Datasources.default.database value.');
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setSecuritySaltAndKey($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $newKey = hash('sha256', Security::randomBytes(64));
        $securityKey = hash('sha256', Security::randomBytes(64));

        $content = str_replace('__SALT__', $newKey, $content, $count);
        $content = str_replace('__KEY__', $securityKey, $content, $count);

        if ($count == 0) {
            $io->write('No Security.salt placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Security.salt value in config/app.php');

            return $newKey;
        }
        $io->write('Unable to update Security.salt value.');
    }

    /**
     * Set up the admin and member password for the database.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $newKey The new security.salt.
     *
     * @return void
     */
    public static function setAccountPassword($dir, $io, $newKey = null)
    {
        if ($newKey == null) {
            $io->write('The new Security.salt value is empty in config/Seeds/UsersSeed.php, can\'t set up the password.');

            return;
        }

        $database = $dir . '/config/Seeds/UsersSeed.php';
        $content = file_get_contents($database);

        $adminPass = 'administrator';
        $memberPass = 'testaccount';

        $hasher = new DefaultPasswordHasher();

        $replacement = [
            $hasher->hash($adminPass),
            $hasher->hash($memberPass),
        ];

        $search = [
            '__ADMINPASSWORD__',
            '__MEMBERPASSWORD__'
        ];

        $content = str_replace($search, $replacement, $content, $count);

        if ($count != 2) {
            $io->write('Error, there was no password to replace.');

            return;
        }

        $result = file_put_contents($database, $content);

        if ($result) {
            $io->write('Set up Admin & Member passwords successfully !');

            return;
        }

        $io->write('Unable to set up Admin & Member passwords.');
    }
}
