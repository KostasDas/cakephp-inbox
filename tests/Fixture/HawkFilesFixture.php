<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HawkFilesFixture
 *
 */
class HawkFilesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'number' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'topic' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'sender' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'protocol' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'null', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'comments' => 'text',
        'location' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
                'number' => '123',
                'type' => 'ΔΒ',
                'topic' => 'τεστ',
                'sender' => 'ΓΕΣ/ΔΠΒ',
                'protocol' => 'Φ.411',
                'comments' => '',
                'location' => '/tmp/test',
                'created' => '2018-05-09 05:09:53',
                'modified' => '2018-05-09 05:09:53'
            ],
            [
                'id' => 2,
                'number' => '321',
                'type' => 'Σημα',
                'topic' => 'Τεστ2',
                'sender' => 'ΑΣΔΥΣ/ΚΕΠΙΚ',
                'protocol' => 'WAF',
                'comments' => 'Ενα τεστ comment',
                'location' => '/tmp/test2',
                'created' => '2018-05-09 05:09:53',
                'modified' => '2018-05-09 05:09:53'
            ],
            [
                'id' => 3,
                'number' => '231',
                'type' => 'Σημα',
                'topic' => 'Τεστ3',
                'sender' => 'ΑΣΔΥΣ/ΔΙΠα',
                'protocol' => 'POF',
                'comments' => '',
                'location' => '/tmp/test3',
                'created' => '2018-05-09 05:09:53',
                'modified' => '2018-05-09 05:09:53'
            ],
        ];
        parent::init();
    }
}
