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
        'app.hawk_files',
        'app.users',
        'app.hawk_users'
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
    // * test find someone elses files
    // * test find many peoples files
    // * test find files that belong to many people
    // test find as author
    // * find file only belongs to me
    // * find file belongs to me and someone else
    // * find file belongs to me and two more people
    // * find file belongs to someone else

    public function testFindAdminAllFiles()
    {
        $this->logInAdmin();
        $files = $this->HawkFiles->find()->contain(['Users'])->all();

        //no files belong to super user but he can see all
        foreach ($files as $file) {
            $this->assertNotEquals($file->users[0]->username, 'grammateia');
        }

    }

    public function testFindAdminSpecificFiles()
    {
        $this->logInAdmin();
        $files = $this->HawkFiles->find()
            ->where(['Users.username' => 'diavivaseis'])
            ->innerJoinWith('Users')
            ->contain(['Users'])
            ->all();

        foreach ($files as $file) {
            $usernames = [];
            foreach ($file->users as $user) {
                $usernames[] = $user->username;
            }
            $this->assertTrue(in_array('diavivaseis', $usernames));
        }
    }


    public function testFindAuthorOwnFiles()
    {

    }

    public function testFindAuthorSharedFiles()
    {

    }

    public function testFindAuthorCommonFiles()
    {

    }

    public function testFindAuthorElsesFiles()
    {

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
        $this->HawkFiles->setUser([
            'id' => 1,
            'username' => 'grammateia',
            'role' => 'admin'
        ]);
    }

    private function logInAuthor($username = '')
    {
        if (!empty($username)) {
            $user = $this->HawkFiles->Users->find()
                ->where(['username' => $username])
                ->firstOrFail();
        }

        $user = !empty($user) ? $user->toArray() : ['username' => 'diavivaseis', 'id' => 2, 'role' => 'author'];
        $this->HawkFiles->setUser($user);
    }
}
