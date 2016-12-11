<?php
namespace App\Shell;

use Cake\Cache\Cache;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Utility\Inflector;

class MaintenanceShell extends Shell
{
    /**
     * The setting key to modify.
     *
     * @var string
     */
    protected $settingKey = 'Site.maintenance';

    /**
     * Initialize method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Settings');
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->description(
            'This shell is used with the maintenance mode in the application.'
        )->addSubcommand('down', [
            'help' => 'Put the website in maintenance mode.'
        ])->addSubcommand('up', [
            'help' => 'Remove the website from the maintenance mode.'
        ]);

        return $parser;
    }

    /**
     * Put the application in maintenance mode.
     *
     * @return bool
     */
    public function down()
    {
        return $this->handleMaintenance('down', '1');
    }

    /**
     * Remove the application from the maintenance mode.
     *
     * @return bool
     */
    public function up()
    {
        return $this->handleMaintenance('up', '0');
    }

    /**
     * Handle the maintenance.
     *
     * @param string $type The type of the maintenance; up, down.
     * @param string $value The value of the setting key.
     *
     * @return bool
     */
    protected function handleMaintenance($type, $value)
    {
        $setting = $this->Settings->find()
            ->where(['name' => $this->settingKey])
            ->first();

        if ($this->checkKey($setting) === false) {
            return false;
        }

        $data = [
            'value_int' => null,
            'value_str' => null,
            'value_bool' => $value
        ];

        $this->Settings->patchEntity($setting, $data);

        if ($this->Settings->save($setting)) {
            Cache::clear(false, 'database');
            $this->out('<success>The</success> "<info>maintenance ' . $type . '</info>" <success>command has been executed successfully !</success>', 2);

            return true;
        } else {
            $this->out('<error>The</error> "<info>maintenance ' . $type . '</info>" <error>has failed while saving the setting key !</error>', 2);

            return false;
        }
    }

    /**
     * Check if the setting key exist in the database.
     *
     * @param null|App\Model\Entity\Setting $setting The setting to check.
     *
     * @return bool
     */
    protected function checkKey($setting)
    {
        if (is_null($setting)) {
            $msg = sprintf(
                'The setting key "%s" can not be found in the database, ' .
                'please add it to use this command shell.',
                $this->settingKey
            );
            $this->error($msg);

            return false;
        }

        return true;
    }
}
