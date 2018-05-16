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

        $this->assertTrue($this->hasOtherUserThan('grammateia', $files));

    }

    private function hasOtherUserThan($username, $files)
    {
        foreach ($files as $file) {
            foreach ($file->users as $user) {
                if ($user->username !== $username) {
                    return true;
                }
            }
        }
        return false;
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
        $this->logInAuthor('3ograf');
        $files = $this->HawkFiles->find()
            ->contain(['Users'])
            ->all();
        foreach ($files as $file) {
            $flag = false;
            foreach ($file->users as $user) {
                if ($user->username === '3ograf') {
                    $flag = true;
                }
            }
            $this->assertTrue($flag);
        }
    }

    public function testFindAuthorSharedFilesFirstUser()
    {
        $this->logInAuthor('3ograf');
        $files = $this->HawkFiles->find('shared');
        foreach ($files as $file) {
            $this->assertTrue(count($file->hawk_users) >= 2);
            $this->assertEquals($file->_matchingData['Users']->username, '3ograf');
        }

    }

    public function testFindAuthorSharedFilesSecondUser()
    {
        $this->logInAuthor('diavivaseis');
        $files = $this->HawkFiles->find('shared');
        foreach ($files as $file) {
            $this->assertTrue(count($file->hawk_users) >= 2 );
            $this->assertEquals($file->_matchingData['Users']->username, 'diavivaseis');
        }
    }
    public function testFindAuthorSharedFilesThirdUser()
    {
        $this->logInAuthor('2ograf');
        $files = $this->HawkFiles->find('shared');
        foreach ($files as $file) {
            $this->assertTrue(count($file->hawk_users) >= 3 );
            $this->assertEquals($file->_matchingData['Users']->username, '2ograf');
        }
    }
    public function testFindAuthorSharedFilesAdmin()
    {
        $this->logInAuthor('grammateia');
        $files = $this->HawkFiles->find('shared');
        foreach ($files as $file) {
            $this->assertTrue(count($file->hawk_users) >= 2 );
        }
    }

    public function testFindAuthorElsesFiles()
    {
        $this->logInAuthor('3ograf');
        $files = $this->HawkFiles->find()
            ->innerJoinWith('Users')
            ->where(['Users.username' => 'diavivaseis'])
            ->all();
        $this->assertEquals(count($files), 0);

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
