<?php
namespace App\Test\TestCase\Controller;

use App\Controller\HawkFilesController;
use Cake\Filesystem\File;
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
        $this->assertResponseContains('files');
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

        $data = json_decode($this->_response->getBody(), true);
        foreach ($data['files'] as $hawkFile) {
            $this->assertEquals($hawkFile['_matchingData']['Users']['username'], 'diavivaseis');
        }
    }

    public function testIndexGenericSearchAsAdmin()
    {
        $this->addTestFiles(5);
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?number=321');
        $data = json_decode($this->_response->getBody(), true);
        foreach ($data['files'] as $file) {
            $this->assertEquals($file['number'], 321);
        }
    }

    public function testIndexGenericSearchAsAuthor()
    {
        $this->addTestFiles(5);
        $this->logInAsAuthor();
        $this->get('/hawk-files.json?number=321');
        $data = json_decode($this->_response->getBody(), true);
        $this->assertTrue(empty($data['files']));
    }

    public function testIndexSearchInboxOnly()
    {
        $this->addTestFiles(10);
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?file_type=εισερχομενο');
        $data = json_decode($this->_response->getBody(), true);
        foreach ($data['files'] as $file) {
            $this->assertEquals('εισερχομενο', $file['file_type']);
        }
    }
    public function testIndexSearchInboxBelongsToDiavivaseis()
    {
        $this->addTestFiles(10);
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?file_type=εισερχομενο&user=2');
        $data = json_decode($this->_response->getBody(), true);
        foreach ($data['files'] as $file) {
            $this->assertEquals('εισερχομενο', $file['file_type']);
            $this->assertEquals($file['_matchingData']['Users']['username'], 'diavivaseis');
        }
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

    private function addTestFiles($times = 1, $users = [])
    {
        //only admins can add files
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        for ($i = 1; $i <= $times; $i++) {
            $data = $this->getFileData($users);
            $this->post('/hawk-files/add.json', $data);
        }
    }

    private function getFileData($userIds = [])
    {
        $users = !empty($userIds) ? $userIds : [
                0 => '3',
                1 => '4'
            ];
        $faker = \Faker\Factory::create();
        $fileName = $faker->word;
        $file = new File('tmp/'.$fileName, true, 0644);
        $protocol = ['Φ.410', 'Φ.420', 'Φ.430', 'Φ.200', 'Φ.210', 'Φ.340'];
        $fileType = ['εξερχομενο', 'εισερχομενο'];
        $file->create();
        return [
            'number' => $faker->numberBetween(10000, 99999),
            'topic' => $faker->word,
            'protocol' => $protocol[array_rand($protocol)],
            'file_type' => $fileType[array_rand($fileType)],
            'type' => 'ΔΒ',
            'sender' => 'ΓΕΣ/ΔΠΒ',
            'user_id' => $users,
            'hawk_file' => [
                'tmp_name' => 'tmp/'.$fileName,
                'error' => (int) 0,
                'name' => 'Φ.330_72_1461730_Σ.916_20 ΑΠΡ 2018_ΓΕΣ_ΔΙΔΕΚΠ_3β.pdf',
                'type' => 'application/pdf',
                'size' => (int) 136916
            ]
        ];
    }
}
