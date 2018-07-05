<?php
namespace app\index\controller;

use app\index\model\Index as IndexModel;
use think\Db;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $list  = IndexModel::all();
        $list2 = Db::name('data')
            ->where('id', 1)
            ->find();
        $this->assign('list', $list);
        $this->assign('meta_title', '测试');
        return $this->fetch();
    }

    public function hello($name = 'World')
    {
        return 'hello,' . $name;
    }
}
