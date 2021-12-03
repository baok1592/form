<?php


namespace ruhua\auth;


use ruhua\bases\BaseValidate;

class GroupValidate extends BaseValidate
{
    protected $rule = [
        'title'  => 'require|max:255',
        'rules' => 'require'
    ];
}