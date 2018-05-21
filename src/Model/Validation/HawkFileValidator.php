<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 19/5/2018
 * Time: 9:38 μμ
 */

namespace App\Model\Validation;


use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

class HawkFileValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();
    }


    public static function transitory(string $protocol, array $requestData): bool
    {
        if (!isset($requestData['data']['type'])) {
            return true;
        }
        if (!HawkFileValidator::isTransitory($requestData['data']['type'])) {
            return true;
        }
        return strpos($protocol, 'Φ.') !== false;

    }

    private static function isTransitory(string $type): bool
    {
        return in_array($type, ['ΔΒ', 'ΔΙΑΒΙΒΑΣΤΙΚΟ', 'ΔΙΑΒ']);
    }

    public static function usersExist(array $users): bool
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        foreach ($users as $id) {
            $user = $usersTable->find()->where(['id' => $id])->first();
            if (empty($user)) {
                return false;
            }
        }
        return true;
    }

    public static function fileFormat(array $file): bool
    {
        $predefinedInputs = ['tmp_name', 'error', 'name', 'type', 'size'];
        foreach ($file as $key => $value) {
            if (!in_array($key, $predefinedInputs)) {
                return false;
            }
        }
        if (empty($file['tmp_name']) || empty($file['name'])) {
            return false;
        }
        return true;
    }


}