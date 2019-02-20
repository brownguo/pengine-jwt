<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/20
 * Time: 下午1:34
 */

class BaseController
{
    public function __construct()
    {
        Pengine::loadLibrary('Jwt');
    }
}