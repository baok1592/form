<?php


namespace app\controller;
require '../vendor/autoload.php';

use app\model\from_key;
use app\model\sys_config;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use app\model\order_post;
use think\Db;

class test
{
        public function d1(){//
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Welcome to Helloweba.');

            $writer = new Xlsx($spreadsheet);
            $name='he3.xlsx';
            $url='../xl/';

            $saveurl=$url.$name;


            $writer->save($saveurl);

        }



    public function getnum($num){
        $numArr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        if(0<=$num&&$num<26){
            return $numArr[$num];
        }else if($num>=26){
            $r=$num%26;
            $l=(int)($num/26);
            return $numArr[$l].$numArr[$r];
        }
    }

    public function dd(){
        $key=from_key::select();
        $n=from_key::select()->count();

        $sys=sys_config::find(14);
        $title=$sys['value'];

        $spreadsheet=new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($title);  //设置当前sheet的标题
        for($i=0;$i<$n;$i++){
            $set=self::getnum($i);

            $sheet->setCellValue($set.'1', $key[$i]['name']);
        }
        $writer = new Xlsx($spreadsheet);
        $name='he.xlsx';
        $url='../xl/';

        $saveurl=$url.$name;


        $writer->save($saveurl);

    }
}