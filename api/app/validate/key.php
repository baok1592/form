<?php


namespace app\validate;


use think\Validate;

class key extends Validate
{
    protected $rule =   [
        'name'  => 'require|unique:from_key',
        'is_search'=>'require',
        'type'=>'require',
        'is_ok'=>'require',
    ];

    protected $message  =   [

    ];

}