<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'role' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'name' => 'Γραμματεία',
                'username' => 'grammateia',
                'password' => '12345',
                'role' => 'admin',
                'created' => '2018-05-15 12:03:24',
                'modified' => '2018-05-15 12:03:24'
            ],
            [
                'id' => 2,
                'name' => 'Διαβιβάσεις',
                'username' => 'diavivaseis',
                'password' => '12345',
                'role' => 'author',
                'created' => '2018-05-15 12:03:24',
                'modified' => '2018-05-15 12:03:24'

            ],
            [
                'id' => 3,
                'name' => '3o Γραφείο',
                'username' => '3ograf',
                'password' => '12345',
                'role' => 'author',
                'created' => '2018-05-15 12:03:24',
                'modified' => '2018-05-15 12:03:24'

            ],
            [
                'id' => 4,
                'name' => '2o Γραφείο',
                'username' => '2ograf',
                'password' => '12345',
                'role' => 'author',
                'created' => '2018-05-15 12:03:24',
                'modified' => '2018-05-15 12:03:24'

            ],
            [
                'id' => 5,
                'name' => 'Διοικητης',
                'username' => 'dioikitis',
                'password' => '12345',
                'role' => 'admin',
                'created' => '2018-05-15 12:03:24',
                'modified' => '2018-05-15 12:03:24'

            ]
        ];
        parent::init();
    }
}
