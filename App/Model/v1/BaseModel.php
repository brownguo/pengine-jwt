<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

class BaseModel
{

    protected $private_key;
    protected $error_code;

    public function __construct()
    {
        $this->_setPrivateKey();
        $this->_setErrorCode();
    }

    public function _setPrivateKey()
    {
        $this->private_key =  Config::get('key');
    }

    protected function _setErrorCode()
    {
        $this->error_code = Config::get('error_code');
    }
}