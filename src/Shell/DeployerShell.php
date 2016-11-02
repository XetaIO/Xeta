<?php
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Utility\Inflector;

class DeployerShell extends Shell
{
    public $tasks = ['ClearCache'];

    /**
     * Start the shell and interactive console.
     *
     * @return void
     */
    public function main()
    {
        $this->out('The following commands can be used when deploying the application.', 2);
        $this->out('<info>Available commands:</info>', 2);
        $names = [];

        foreach ($this->tasks as $task => $value) {
            $names[] = Inflector::underscore($task);
        }

        sort($names);

        foreach ($names as $name) {
            $this->out('- <error>' . $name . '</error>');
        }

        $this->out('');
        $this->out('By using <info>`cake deployer [name]`</info> you can invoke a specific bake task.');
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = new ConsoleOptionParser('deployer', false);
        $parser->description(
            'This shell is used when deploying the application.'
        )->addSubcommand('clear_cache', [
            'help' => 'Clear the cache files.',
            'parser' => $this->ClearCache->getOptionParser()
        ]);

        return $parser;
    }
}
