<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HawkFilesTable;
use Cake\Http\Exception\UnauthorizedException;
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

    // test find as super user
    // * test find own files
    // * test find someone elses files
    // * test find many peoples files
    // test find as author
    // * find file only belongs to me
    // * find file belongs to me and someone else
    // * find file belongs to me and two more people
    // * find file belongs to someone else

    public function testFindAdminAllFiles()
    {
        $this->logInAdmin();
        $files = $this->HawkFiles->find()->all();

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

    private  function logInAdmin()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'grammateia',
                ]
            ]
        ]);
    }

    private function logInAuthor($username = '')
    {
        if (!empty($username)) {
            $user = $this->HawkFiles->Users->find()
                ->where(['username' => $username])
                ->firstOrFail();
        }

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => $user->id ?? '2',
                    'username' => $user->username ?? 'diavivaseis'
                ]
            ]
        ]);
    }
}
