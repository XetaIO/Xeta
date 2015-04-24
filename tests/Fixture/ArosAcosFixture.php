<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ArosAcosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'aro_id' => ['type' => 'integer'],
        'aco_id' => ['type' => 'integer'],
        '_create' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
        '_read' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
        '_update' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
        '_delete' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
        '_indexes' => [
            'idx_aco_id' => ['type' => 'index', 'columns' => ['aco_id']],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        ['id' => '1', 'aro_id' => '5', 'aco_id' => '1', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '2', 'aro_id' => '1', 'aco_id' => '1', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '3', 'aro_id' => '2', 'aco_id' => '1', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '4', 'aro_id' => '2', 'aco_id' => '2', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '5', 'aro_id' => '2', 'aco_id' => '4', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '6', 'aro_id' => '2', 'aco_id' => '17', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '7', 'aro_id' => '2', 'aco_id' => '19', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '8', 'aro_id' => '2', 'aco_id' => '23', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '9', 'aro_id' => '2', 'aco_id' => '29', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '20', 'aro_id' => '3', 'aco_id' => '1', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '21', 'aro_id' => '3', 'aco_id' => '2', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '22', 'aro_id' => '3', 'aco_id' => '4', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '23', 'aro_id' => '3', 'aco_id' => '17', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '24', 'aro_id' => '3', 'aco_id' => '19', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '25', 'aro_id' => '3', 'aco_id' => '23', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '26', 'aro_id' => '3', 'aco_id' => '29', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '27', 'aro_id' => '3', 'aco_id' => '44', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '28', 'aro_id' => '3', 'aco_id' => '57', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '29', 'aro_id' => '3', 'aco_id' => '62', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '30', 'aro_id' => '3', 'aco_id' => '78', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '31', 'aro_id' => '4', 'aco_id' => '1', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '32', 'aro_id' => '4', 'aco_id' => '2', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '33', 'aro_id' => '4', 'aco_id' => '4', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '34', 'aro_id' => '4', 'aco_id' => '17', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '35', 'aro_id' => '4', 'aco_id' => '19', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '36', 'aro_id' => '4', 'aco_id' => '23', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '37', 'aro_id' => '4', 'aco_id' => '29', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '38', 'aro_id' => '4', 'aco_id' => '44', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '39', 'aro_id' => '4', 'aco_id' => '45', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '40', 'aro_id' => '4', 'aco_id' => '80', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1']
    ];
}
