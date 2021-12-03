<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('', function () {
	 echo '万能预约系统' . VAE_VERSION . '(开源版)';
});
/**
 * 系统安装
 */
Route::group('install', function () {
    Route::get('', 'install.Index/step1');
    Route::get('step2', 'install.Index/step2');
    Route::get('step3', 'install.Index/step3');
    Route::post('create_data', 'install.Index/createData');
});
/**
 * 用户管理
 */
Route::group('order', function () {

    Route::group('', function () {
        Route::post('add_order', 'user.Order/add')->middleware('checkOrder'); //预约
        Route::put('cout_add_num', 'user.Order/cout'); //预约人数获取

        Route::post('select_order', 'user.Order/selectmine'); //数据库形式的查询
        Route::get('getdate', 'user.Order/getdate')->middleware('checkOrder'); ; //预约日期获取
        Route::get('update', 'user.Order/update'); //预约信息更新，将已经过了时间段的预约段的完成值为0 //服务器定时函数
        Route::post('close', 'user.Order/close');
    });
    Route::group('', function () {
        Route::get('off_order', 'user.Order/off'); //预约开关
        Route::post('get_order', 'user.Order/get'); //预约信息获取
        Route::post('order_close', 'user.Order/close'); //取消预约
        Route::delete('closeall', 'user.Order/closeall'); //清空预约信息并保存一份last.xlsx
    })->middleware('checkcms');

});


//公共
Route::group('sys', function () {
    Route::get('get_sys', 'cms.Sys/get'); //获取配置讯息
    Route::post('dd', 'test/dd'); //测试
    Route::get('getkey', 'cms.Sys/getkey'); //获取查询关键词
    Route::group('', function () {
        Route::post('edit', 'cms.Sys/update'); //修改配置讯息
        Route::post('edkey', 'cms.Sys/edkey'); //修改查询关键词

    })->middleware('checkcms');
});

Route::group('fromkey', function () {

    Route::get('get_key', 'cms.FromKey/get'); //获取

    Route::group('', function () {
        Route::post('addall', 'cms.FromKey/addall'); //覆盖修改

        //Route::put('remove', 'cms.FromKey/del'); //删除
        //Route::post('add', 'cms.FromKey/add'); //添加
        //Route::post('edit', 'cms.FromKey/edit'); //修改

    })->middleware('checkcms');
});

Route::group('excel', function () {
    Route::post('excel_getse', 'cms.Excel/getse'); //获取表头关键词
    Route::get('excel_get', 'cms.Excel/get'); //获取
    Route::post('select_pro', 'cms.Excel/select'); //缓存查询
    Route::post('exselect', 'cms.Excel/exselect'); //excel查询
    Route::post('newname','cms.Excel/new');//加xlsx后缀
    Route::post('upload','cms.Excel/upload');//上传excel文件
    Route::group('', function () {
        Route::post('out', 'cms.Excel/dd'); //导出表
        //Route::post('put', 'cms.Excel/importexcel'); //导入表  弃用
        Route::post('move', 'cms.Excel/move');//生成
        Route::post('del_excel', 'cms.Excel/del');//生成
        Route::post('search', 'cms.Excel/givesearch'); //给查询关键词
        Route::post('exadd', 'cms.Excel/exceladd'); //项目表新增数据  //无用
    })->middleware('checkcms');
});

Route::group('admin', function () {

    Route::post('login', 'cms.Admin/login'); //登录
    Route::get('get_admin', 'cms.Admin/get'); //获取管理员
    Route::group('',function (){
        Route::get('check','cms.Admin/check');
        Route::post('editpwd', 'cms.Admin/editPSW'); //修改密码
        Route::post('add_admin', 'cms.Admin/add'); //新增管理员
        Route::post('del', 'cms.Admin/del'); //删除
        Route::post('ed_pwd', 'cms.Admin/ed_pwd'); //修改密码
    })->middleware('checkcms');

});










