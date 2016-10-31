<?php
namespace App\Routing;

use App\Routing\Exception\MissingFileException;

class Routes
{
    /**
     * Load one or more routes files.
     *
     * ### Usage
     *
     * Loading one file:
     *
     * ```
     * Routes::load('base');
     * ```
     *
     * Loading many files at once:
     *
     * ```
     * Routes::load(['base', 'blog', 'admin']);
     * ```
     *
     * @param string|array $files The file(s) to load.
     *
     * @return void
     */
    public static function load($files = [])
    {
        foreach ((array)$files as $file) {
            if (empty($file) || is_null($file)) {
                continue;
            }

            $path = ROUTES . strtolower($file) . '.php';

            if (!file_exists($path)) {
                $msg = sprintf('The Route file "%s" could not be found.', $path);

                throw new MissingFileException($msg);
            }

            include $path;
        }
    }
}
