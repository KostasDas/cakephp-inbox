<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HawkUsersFixture
 *
 */
class HawkUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'hawk_file_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'hawk_file_id' => ['type' => 'index', 'columns' => ['hawk_file_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'hawk_users_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'hawk_users_ibfk_2' => ['type' => 'foreign', 'columns' => ['hawk_file_id'], 'references' => ['hawk_files', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 2,
                'hawk_file_id' => 1
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'hawk_file_id' => 2
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'hawk_file_id' => 3
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'hawk_file_id' => 3
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'hawk_file_id' => 4
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'hawk_file_id' => 4
            ],
            [
                'id' => 7,
                'user_id' => 4,
                'hawk_file_id' => 4
            ],
        ];
        parent::init();
    }
}
