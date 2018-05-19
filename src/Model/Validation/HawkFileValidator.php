<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 19/5/2018
 * Time: 9:38 μμ
 */

namespace App\Model\Validation;


use Cake\Validation\Validator;

class HawkFileValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();
    }


    public static function transitory($protocol, $requestData)
    {
        if (!HawkFileValidator::isTransitory($requestData['data']['type'])) {
            return true;
        }
        return strpos($protocol, 'Φ.') !== false;

    }

    private static function isTransitory($type)
    {
        return in_array($type, ['ΔΒ', 'ΔΙΑΒΙΒΑΣΤΙΚΟ', 'ΔΙΑΒ']);
    }


}