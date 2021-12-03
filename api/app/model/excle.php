<?php


namespace app\model;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ruhua\exceptions\BaseException;
use think\facade\Cache;
use think\Model;
use think\facade\Validate;
use think\model\concern\SoftDelete;

class excle extends Model
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    static public function add($data)
    {
        //存在同名则覆盖 不存在就创建
        $re = self::where(['name' => $data['name']])->find();
        if ($re) {
            $re['frist_name'] = $data['frist_name'];
            $re['url'] = $data['url'];

            $re['xname'] = $data['xname'];
            $re->save();
            return $re;
        }
        $res = self::create($data);

        return $res;
    }

    static public function imexcel()
    {
        $re = request()->param();
        $f = $re['url'];
        $url = '../xl/';
        $name = 'last.xlsx';
        excle::dd($name, $url);      //保存上一份表单的所有数据，同时清空当前表单关键词

        $sheetdata = excle::getarr($f);

        if (!$sheetdata) {
            throw new BaseException(['msg' => '该文件地址可能有误']);
        }
        //from_key::deleteall();  //清除之前的key
        $i = 0;
        foreach ($sheetdata[0] as $s) {        //存储时以列名做为标识key
            $data = [
                'keyname' => excle::getnum($i),
                'name' => $s
            ];

            from_key::create($data);
            $i++;
        }
        //

        return app('json')->go(['msg' => '导入成功']);
    }

    static public function getarr($file_url)
    {    //获取excel数组

        $inputFileType = IOFactory::identify($file_url); //传入Excel路径

        $excelReader = IOFactory::createReader($inputFileType); //Xlsx

        $PHPExcel = $excelReader->load($file_url); // 载入excel文件

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        return $sheet->toArray();
    }

    static public function getinfo($id)
    {

        $f = excle::find($id);

        $data = [
            'url' => $f['url'] . $f['name'],
            'name' => $f['name'] . $id,
            'search_key' => explode('@', $f['search_key']),
            'frist_name' => explode('@', $f['frist_name']),
        ];
        return $data;
    }

    static public function setsearch($id, $str)
    {  //新增搜索关键词
        $re = self::find($id);
        if (!$re) {
            throw new BaseException(['msg' => '该项目id不存在']);
        }
        if (!$str) {
            throw new BaseException(['msg' => '搜索关键词不能为空']);
        }


        $re['search_key'] = $str;
        $re->save();
        return 1;
    }

    static public function getexcel($id)  //获取缓存中存放的excel
    {
        $f = self::getinfo($id);
        $data = Cache::get($f['name'] . $id);

        if (!$data) {
            $data = self::getexcelarr($id);
            if (empty($data)) {
                throw new BaseException(['msg' => '暂时没有数据']);
            }
        }
        return $data;
    }

    static public function getnum($num)  //根据数字获取列名   0=>A 26=>AA
    {
        $numArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        if (0 <= $num && $num < 26) {
            return $numArr[$num];
        } else if ($num >= 26) {
            $r = $num % 26;
            $l = (int)($num / 26);
            return $numArr[$l] . $numArr[$r];
        }
        throw new BaseException(['msg' => '获取列名失败']);
    }

    static public function newname($name)
    {
        $arr = explode('.', $name);
        $n = count($arr);
        if ($arr[$n - 1] != 'xlsx') {
            $arr[$n] = 'xlsx';
        }
        $name = implode('.', $arr);
        return $name;
    }

    static public function shortname($name)
    {
        $arr = explode('.', $name);
        echo $arr[0];
        return $arr[0];
    }

    static public function dd($name, $url)//导出
    {
        $xname = $name;
        $name = self::newname($name);
        $key = from_key::select();
        $n = $key->count();

        $order_data = order::where(['is_new' => 1])->select();
        $n2 = $order_data->count();

        //$sys = sys_config::find(14);
        //$title = $sys['value'];
        $f_name = '';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //$sheet->setTitle($title);  //设置当前sheet的标题

        for ($i = 0; $i < $n; $i++) {  //输出表头
            $set = self::getnum($i);

            $sheet->setCellValue($set . '1', $key[$i]['name']);
            if ($i == 0)
                $f_name = $key[$i]['name'];
            else {
                $f_name = $f_name . '@' . $key[$i]['name'];
            }

        }

        for ($j = 0; $j < $n2; $j++) {      //循环输出表
            $js = $order_data[$j]['json'];

            $json = json_decode($js, true);

            for ($i = 0; $i < $n; $i++) {
                $set = self::getnum($i);

                $sheet->setCellValue($set . ($j + 2), $json[$key[$i]['keyname']]);
            }

        }

        $writer = new Xlsx($spreadsheet);    //保存文件
        $saveurl = $url . $name;
        $writer->save($saveurl);

        $sys = sys_config::getkey2();

        $key1 = from_key::where('keyname', $sys['key1'])->field('name')->select();
        if ($sys['n'] == 2)
        $key2 = from_key::where('keyname', $sys['key2'])->field('name')->select();
        if ($sys['n'] == 3)
            $key3 = from_key::where('keyname', $sys['key3'])->field('name')->select();

        $str = $key1['0']['name'] . '@';

        if ($sys['n'] >= 2) {

            $str = $str . $key2['0']['name'];

        }

        if ($sys['n'] >= 3)
            $str = $str . '@' . $key3['0']['name'];

        //保存表信息

        $data = [
            'name' => $name,
            'url' => $url,
            'frist_name' => $f_name,
            'search_key' => $str,
            'xname' => $xname
        ];

        $res = excle::add($data);

        return $res;
    }

    static public function getexcelarr($id)  //将excel数据放入缓存  默认为操控预约项目
    {
        $f = self::getinfo($id);

        $sheetdata = self::getarr($f['url']);

        self::savekey($id);
        Cache::set($f['name'], $sheetdata, 3600 * 24 * 2);

        return $sheetdata;
    }

    static public function addnewdata($id, $newdata)
    {  //对某表增加新数据
        $f = self::getinfo($id);
        $sheetdata = self::getarr($f['url']);
        $n = count($sheetdata);

        $inputFileType = IOFactory::identify($f['url']); //传入Excel路径
        $excelReader = IOFactory::createReader($inputFileType); //Xlsx
        $PHPExcel = $excelReader->load($f['url']); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

        for ($i = 0; $i < $n; $i++) {
            $set = self::getnum($i);
            $sheet->setCellValue($set . ($n + 2), $newdata[$set]);//按照表头顺序填入
        }

        return 1;
    }

    static public function exselect($re)
    {  //excel查询   如果缓存查得到就不用execl查询

        excle::F5($re['id']);  //更新缓存
        $f = self::getinfo($re['id']);
        $data = self::getarr($f['url']);
        $s = $f['search_key'];
        $sn = count($s);
        $h = $f['frist_name'];
        $hn = count($h);

        for ($i = 0; $i < $hn; $i++) {
            for ($j = 0; $j < $sn; $j++) {
                if ($s[$j] == $h[$i]) {  //获取查询关键词在哪几列
                    $l[$j] = $i;
                }
            }

        }
        $LL = 0;

        foreach ($data as $i) {
            $ok = 0;
            $LL++;     //记录第几条
            for ($q = 0; $q < $sn; $q++) {
                if(!$re['key' . ($q + 1)]){
                    throw new BaseException(['msg'=>'请输入第'.($q+1).'项']);
                }
                if ($i[$l[$q]] == $re['key' . ($q + 1)]) {
                    $ok++;
                }
            }


            if ($ok == $sn) {   //满足查询关键词

                $da['column'] = $LL;  //在第几列

                for ($x = 0; $x < $hn; $x++) {
                    $da[self::getnum($x)] = $i[$x];     //keyname 列名  name  关键词中文
                }

                return $da;
            }

        }

       throw new BaseException(['msg'=>'未能查询到该条数据']);
    }//excel查询c

    static public function Chaceselect()
    {
        $re = request()->post();

        $id = $re['id'];
        $f = self::getinfo($re['id']);
        $data = Cache::get($f['name']);
        if (!$data) {    //若获取不到数据则刷新一次
            self::exselect($re);
        }
        $s = Cache::get('key' . $id);
        $sn = count($s);
        $h = Cache::get('keyname' . $id);
        $hn = count($h);

        for ($i = 0; $i < $hn; $i++) {
            for ($j = 0; $j < $sn; $j++) {
                if ($s[$j] == $h[$i]) {  //获取查询关键词在哪几列
                    $l[$j] = $i;

                }
            }

        }
        $LL = 0;

        if(!$data){

            $res=self::exselect($re);
            if($res){
                return app('json')->go($res);
            }
            throw new BaseException(['msg'=>'未能查询到该条数据,或者请稍后再试']);
        }
        else{
            foreach ($data as $i) {
                $ok = 0;
                $LL++;     //记录第几条
                for ($q = 0; $q < $sn; $q++) {
                    if ($i[$l[$q]] == $re['key' . ($q + 1)]) {
                        $ok++;
                    }
                }

                if ($ok == $sn) {   //满足查询关键词

                    $da['column'] = $LL;  //在第几列

                    for ($x = 0; $x < $hn; $x++) {
                        $da[self::getnum($x)] = $i[$x];     //keyname 列名  name  关键词中文
                    }
                    return app('json')->go($da);
                }
            }
        }

    }//缓存查询  如果第一次没查到 就更新+excel查询

    static public function F5($id)
    {//刷新  当某次查询在缓存中找不到对应值的时候立即刷新
        $re = excle::getexcelarr($id);
        return app('json')->go(['msg' => '更新完成,缓存已更新']);
    }   //刷新

    static public function savekey($id)
    { //设置关键词
        $f = self::getinfo($id);
        Cache::set('keyname' . $id, $f['frist_name'], 3600 * 24 * 2);
        Cache::set('key' . $id, $f['search_key'], 3600 * 24 * 2);
    }  //把搜索关键词和关键词放入


}