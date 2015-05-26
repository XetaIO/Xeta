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
        ['id' => '31', 'aro_id' => '4', 'aco_id' => '1', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '39', 'aro_id' => '4', 'aco_id' => '45', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '40', 'aro_id' => '4', 'aco_id' => '80', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '41', 'aro_id' => '4', 'aco_id' => '121', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '42', 'aro_id' => '3', 'aco_id' => '85', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '43', 'aro_id' => '3', 'aco_id' => '92', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '44', 'aro_id' => '3', 'aco_id' => '97', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '45', 'aro_id' => '3', 'aco_id' => '98', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '46', 'aro_id' => '3', 'aco_id' => '100', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '47', 'aro_id' => '3', 'aco_id' => '101', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '48', 'aro_id' => '3', 'aco_id' => '108', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '49', 'aro_id' => '2', 'aco_id' => '85', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '50', 'aro_id' => '2', 'aco_id' => '92', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '53', 'aro_id' => '2', 'aco_id' => '100', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '54', 'aro_id' => '2', 'aco_id' => '101', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '55', 'aro_id' => '2', 'aco_id' => '108', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '56', 'aro_id' => '2', 'aco_id' => '120', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '57', 'aro_id' => '2', 'aco_id' => '114', '_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1'],
        ['id' => '58', 'aro_id' => '2', 'aco_id' => '132', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '59', 'aro_id' => '2', 'aco_id' => '136', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '60', 'aro_id' => '3', 'aco_id' => '132', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1'],
        ['id' => '61', 'aro_id' => '3', 'aco_id' => '136', '_create' => '1', '_read' => '1', '_update' => '1', '_delete' => '1']
    ];
}
