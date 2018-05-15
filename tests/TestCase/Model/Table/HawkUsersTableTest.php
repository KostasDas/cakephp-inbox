<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HawkUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HawkUsersTable Test Case
 */
class HawkUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HawkUsersTable
     */
    public $HawkUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hawk_users',
        'app.users',
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
        $config = TableRegistry::exists('HawkUsers') ? [] : ['className' => HawkUsersTable::class];
        $this->HawkUsers = TableRegistry::get('HawkUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HawkUsers);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
