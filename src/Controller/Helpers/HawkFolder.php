<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 27/4/2018
 * Time: 11:54 μμ
 */

namespace App\Controller\Helpers;


use App\Model\Entity\HawkFile;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\I18n\Time;

class HawkFolder
{
    protected $directory;

    public function __construct($path)
    {
        $this->directory = new Folder($path, true, 0755);
    }

    public function moveToProduction(File $file, string $fileName): string
    {
        $fileName = $this->uniqueFileName($fileName);
        if ($file->copy($this->directory->path . DS . $fileName)) {
            return $this->directory->path . DS . $fileName;
        }
        return false;
    }

    public function movePhoto(File $file): string
    {
        $fileName = $this->uniqueFileName('.PNG', true);

        return $this->moveToProduction($file, $fileName);
    }

    public function delete(string $path): bool
    {
        $file = new File($path);
        return $file->delete();
    }

    public function deleteDir(): bool
    {
        if (empty($this->directory->find())) {
            $this->directory->find();
            return $this->directory->delete();
        }
        return false;
    }

    private function uniqueFileName(string $fileName, $isPhoto = false): string
    {
        if (!in_array($fileName, $this->directory->find()) && !$isPhoto) {
            return $fileName;
        }

        $parts = pathinfo($fileName);
        $fileName = $parts['filename'];
        $fileName = $fileName . uniqid("", true);
        if (!empty($parts['extension'])) {
            $fileName = $fileName . '.' . $parts['extension'];
        }
        return $fileName;
    }

    public function exists(): bool
    {
        return !empty($this->directory->path);
    }

}