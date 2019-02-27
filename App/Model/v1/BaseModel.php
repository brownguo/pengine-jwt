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
    protected $access_Exp  = 3600;
    protected $refresh_Exp = 7200;

    public function __construct()
    {
        $this->_setPrivateKey();
    }

    public function _setPrivateKey()
    {
        $this->private_key =  Config::get('key');
    }
}