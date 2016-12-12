<?php
namespace App\Shell\Task;

use Cake\Cache\Cache;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;

class ClearCacheTask extends Shell
{
    /**
     * Execute the ClearCache task.
     *
     * @return void
     */
    public function main()
    {
        Cache::clear(false, '_cake_core_');
        Cache::clear(false, 'database');
        Cache::clear(false, 'statistics');
        Cache::clear(false, 'acl');
        $this->out('<info>The</info> "<error>deployer clear_cache</error>" <info>command has been executed successfully !</info>', 2);
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = new ConsoleOptionParser('clear_cache', false);
        $parser->description(
            'This task is used to clear the cached files in the application.'
        );

        return $parser;
    }
}
