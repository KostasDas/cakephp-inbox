<?php
namespace App\Test\TestCase\Controller;

use App\Controller\HawkFilesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\HawkFilesController Test Case
 */
class HawkFilesControllerTest extends IntegrationTestCase
{

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



    // add
    // visit add page not logged in
    // visit add page as author
    // visit add page as admin
    // post add as author
    // post add as not logged in
    // post add as admin empty data
    // post add as admin for one user
    // post add as admin for two users
    // post add as admin for multiple users
    // post add as admin
    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexNotLoggedIn()
    {
        $this->get('/hawk-files');
        $this->assertRedirect();
    }

    public function testIndexJsonNotLoggedIn()
    {
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/hawk-files.json');
        $this->assertRedirect();

    }

    public function testIndexAdmin()
    {
        $this->logInAsAdmin();

        $this->get('/hawk-files');
        $this->assertResponseSuccess();
    }

    public function testIndexJsonAdmin()
    {
        $this->logInAsAdmin();

        $this->get('/hawk-files.json');
        $this->assertResponseSuccess();
    }


    public function testIndexAuthor()
    {
        $this->logInAsAuthor();

        $this->get('/hawk-files');
        $this->assertResponseSuccess();
    }
    public function testIndexJsonAuthor()
    {
        $this->logInAsAuthor();

        $this->get('/hawk-files.json');
        $this->assertResponseSuccess();
    }

    public function testIndexSearchAsAdmin()
    {

    }

    public function testIndexSearchAsAuthor()
    {

    }
    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    private function logInAsAdmin()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'name' => 'γραμματεία',
                    'username' => 'grammateia',
                    'role' => 'admin'
                ]
            ]
        ]);
    }
    private function logInAsAuthor()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'name' => 'Διαβιβάσεις',
                    'username' => 'diavivaseis',
                    'role' => 'author'
                ]
            ]
        ]);
    }
}
