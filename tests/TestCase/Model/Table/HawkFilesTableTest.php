<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HawkFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HawkFilesTable Test Case
 */
class HawkFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HawkFilesTable
     */
    public $HawkFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hawk_files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('HawkFiles') ? [] : ['className' => HawkFilesTable::class];
        $this->HawkFiles = TableRegistry::get('HawkFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HawkFiles);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
