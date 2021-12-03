<?php


namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

class admin extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}