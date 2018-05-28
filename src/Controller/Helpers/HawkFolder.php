<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 27/4/2018
 * Time: 11:54 μμ
 */

namespace App\Controller\Helpers;


use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class HawkFolder
{
    protected $directory;
    private $tempFile;

    public function setPath(array $data)
    {
        Configure::load('file_directories', 'default');
        $path = $this->createPathFromData($data);
        $folder = new Folder('/');
        $folder->create($path);
        $this->directory = new Folder($path);
        if (!$this->validateDirectory()) {
            throw new Exception('Something went wrong when creating directories');
        }
    }

    public function moveToProduction(array $fileInput): string
    {
        $file = $this->createFileFromInput($fileInput);
        $file->copy($this->directory->path . DS . $fileInput['name']);
        $this->tempFile = new File($this->directory->path . DS . $fileInput['name']);
        return $this->tempFile->path;
    }

    public function deleteCurrentFile(): bool
    {
        if (empty($this->tempFile)) {
            return false;
        }
        return $this->tempFile->delete();
    }

    public function deleteDir(): bool
    {
        if (empty($this->directory)) {
            return false;
        }
        if (empty($this->directory->find())) {
            return $this->directory->delete();
        }
        return false;
    }
// not used currently
//    private function uniqueFileName(string $fileName, Folder $directory): string
//    {
//        if (!in_array($fileName, $directory->find())) {
//            return $fileName;
//        }
//        $parts = pathinfo($fileName);
//        $fileName = $parts['filename'];
//        $fileName = $fileName . uniqid("", true);
//        if (!empty($parts['extension'])) {
//            $fileName = $fileName . '.' . $parts['extension'];
//        }
//        return $fileName;
//    }

    private function createPathFromData(array $data): string
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        if (!$this->validatePathData($data)) {
            throw new InvalidArgumentException('Please make sure you provided users, protocol and file type');
        }
        $protocol = $this->roundProtocol($data['protocol']);
        $name = $usersTable->get($data['user_id'])->username;
        return Configure::read('path') . DS . $name . DS . $data['file_type'] . DS . $protocol;
    }

    private function roundProtocol($protocol):string
    {
        $number = str_replace('Φ.', '', $protocol);
        if ($number === $protocol) {
            return $protocol;
        }
        return 'Φ.' . floor((float) $number /100) * 100;
    }
    private function validatePathData(array $data): bool
    {
        $pass = true;
        $necessary = ['user_id', 'protocol', 'file_type'];
        foreach ($necessary as $item) {
            if (empty($data[$item])) {
                $pass = false;
            }
        }
        return $pass;
    }

    private function createFileFromInput(array $fileInput):File
    {
        if (empty($fileInput['tmp_name'])) {
            throw new InvalidArgumentException('The provided file input is invalid');
        }

        return new File($fileInput['tmp_name']);
    }

    private function validateDirectory()
    {
        return !is_null($this->directory->path);
    }

}