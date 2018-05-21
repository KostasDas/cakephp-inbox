<?php
namespace App\Test\TestCase\Controller;

use App\Model\Entity\HawkUser;
use App\Model\Table\HawkFilesTable;
use App\Model\Table\HawkUsersTable;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
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

    public function tearDown()
    {
        //delete generated folders after every test
        Configure::load('file_directories', 'default');
        $folder = new Folder(Configure::read('path'));
        $folder->delete();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }



    // add
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

    public function testIndexSearchProtocolTransitoryExactMatch()
    {
        $this->addTestFiles(10);
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?protocol=410');
        $data = json_decode($this->_response->getBody(), true);
        $this->assertTrue(!empty($data['files']));
        foreach ($data['files'] as $file) {
            $this->assertEquals('Φ.410', $file['protocol']);
        }
        $this->get('/hawk-files.json?protocol=Φ.410');
        $newData = json_decode($this->_response->getBody(), true);
        $this->assertEquals($data['files'], $newData['files']);

    }

    public function testIndexSearchProtocolTransitoryRounded()
    {
        $this->addTestFiles(10);
        $this->logInAsAuthor();
        $this->get('/hawk-files.json?protocol=400');
        $data = json_decode($this->_response->getBody(), true);
        $this->assertTrue(!empty($data['files']));
        foreach ($data['files'] as $file) {
            $this->assertTrue($file['protocol'] >= 'Φ.400' && $file['protocol'] < 'Φ.499');
        }
        $this->get('/hawk-files.json?protocol=Φ.4');
        $newData = json_decode($this->_response->getBody(), true);
        $this->assertEquals($data['files'], $newData['files']);
    }

    public function testIndexSearchProtocolNotTransitory()
    {
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?protocol=WAF');
        $data = json_decode($this->_response->getBody(), true);
        $this->assertTrue(!empty($data['files']));
        foreach ($data['files'] as $file) {
            $this->assertEquals($file['protocol'], 'WAF');
        }

    }

    public function testIndexSearchProtocolTransitoryRoundedWithUser()
    {
        $this->logInAsAdmin();
        $this->get('/hawk-files.json?protocol=400&user=2');
        $data = json_decode($this->_response->getBody(), true);
        $this->assertTrue(!empty($data['files']));
        foreach ($data['files'] as $file) {
            $this->assertTrue($file['protocol'] >= 'Φ.400' && $file['protocol'] < 'Φ.499');
            $this->assertEquals($file['_matchingData']['Users']['username'], 'diavivaseis');
        }
    }

    public function testAddVisitNotLogged()
    {
        $this->get('/hawk-files/add');
        $this->assertRedirect('/?redirect=%2Fhawk-files%2Fadd');

    }

    public function testAddVisitAsAuthor()
    {
        $this->logInAsAuthor();
        $this->get('/hawk-files/add');
        $this->assertRedirect(['controller' => 'HawkFiles', 'action' => 'index']);

    }

    public function testAddVisitAsAdmin()
    {
        $this->logInAsAdmin();
        $this->get('/hawk-files');
        $this->assertResponseSuccess();

    }

    public function testAddPostNotLogged()
    {
        $this->enableCsrfToken();
        $this->post('/hawk-files/add', $this->getFileData());
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function testAddPostAsAuthor()
    {
        $this->logInAsAuthor();
        $this->enableCsrfToken();
        $this->post('/hawk-files/add', $this->getFileData());
        $this->assertRedirect(['controller' => 'HawkFiles', 'action' => 'index']);
    }

    public function testAddPostAsAdminSuccessOneUser()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['user_id'] = ['3'];
        $data['topic'] = 'SpecificTopicOneUser';
        $this->post('/hawk-files/add', $data);
        $this->assertRedirect(['controller' => 'HawkFiles', 'action' => 'index']);
        $this->assertTrue($this->checkHawkUsersExist($data['topic'], $data['user_id']));
    }

    public function testAddPostAsAdminMultipleUsers()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['topic'] = 'SpecificTopicMultipleUsers';
        $this->post('/hawk-files/add', $data);
        $this->assertRedirect(['controller' => 'HawkFiles', 'action' => 'index']);
        $this->assertTrue($this->checkHawkUsersExist($data['topic'], $data['user_id']));
    }

    public function testAddPostValidationFailTopic()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['topic'] = '';
        $data['number'] = '132546879';
        $this->post('/hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('number', $data['number']));

        unset($data['topic']);
        $this->post('hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('number', $data['number']));

    }

    public function testAddPostValidationFailProtocol()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['protocol'] = '';
        $data['number'] = '132546879';
        $this->post('/hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('number', $data['number']));

        $data['protocol'] = '821';
        $this->post('hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('number', $data['number']));


        unset($data['protocol']);
        $this->post('hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('number', $data['number']));

    }

    public function testAddPostValidationFailUsers()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['user_id'] = [];
        $data['topic'] = 'topicFailUsers';
        $this->post('/hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));

        // user id doesn't exist
        $data['user_id'] = ['999999'];
        $this->post('/hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));

        unset($data['user_id']);
        $this->post('/hawk-files/add', $data);
        $this->assertResponseContains('error');
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));


    }

    public function testAddPostValidationFailFile()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['hawk_file'] = [];
        $data['topic'] = 'topicFailFile';
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));

        $data['hawk_file'] = ['size' => 'bogus stuff'];
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));

        unset($data['hawk_file']);
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));
    }

    public function testAddPostValidationFailType()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['type'] = '';
        $data['topic'] = 'topicFailType';
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));

        unset($data['type']);
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));
    }

    public function testAddPostValidationFailSender()
    {
        $this->logInAsAdmin();
        $this->enableCsrfToken();
        $data = $this->getFileData();
        $data['sender'] = '';
        $data['topic'] = 'topicFailSender';
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));
        unset($data['sender']);
        $this->post('/hawk-files/add', $data);
        $this->assertTrue($this->fileDoesNotExist('topic', $data['topic']));
    }

    private function fileDoesNotExist($field, $value)
    {
        $config = TableRegistry::exists('HawkFiles') ? [] : ['className' => HawkFilesTable::class];
        $hawkFilesTable = TableRegistry::get('HawkFiles', $config);

        $addedFile = $hawkFilesTable->find()->where([$field => $value])->first();
        return empty($addedFile);
    }

    private function checkFileLocationExists($hawkUsers)
    {
        foreach ($hawkUsers as $entry) {
            $file = new File($entry->location);
            if (!$file->exists()) {
                return false;
            }
        }
        return true;
    }

    private function checkHawkUsersExist($topic, $users)
    {
        $config = TableRegistry::exists('HawkFiles') ? [] : ['className' => HawkFilesTable::class];
        $hawkFilesTable = TableRegistry::get('HawkFiles', $config);

        $addedFile = $hawkFilesTable->find()->where(['topic' => $topic])->first();
        if (empty($addedFile)) {
            return false;
        }

        $config = TableRegistry::exists('HawkUsers') ? [] : ['className' => HawkUsersTable::class];
        $hawkUsersTable = TableRegistry::get('HawkUsers', $config);

        $entries = [];
        foreach ($users as $id) {
            $entry = $hawkUsersTable->find()->where([
                'user_id' => $id,
                'hawk_file_id' => $addedFile->id
            ])->first();
            if (empty($entry)) {
                return false;
            }
            $entries[] = $entry;
        }
        return $this->checkFileLocationExists($entries);

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
