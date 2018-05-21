<?php
namespace app\api\controller\v1;

use app\api\model\Index as IndexModel;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $list = IndexModel::all();
        if ($list) {
        	return json($list);
        } else {
        	return json(['error' => '数据不存在'], 404);
        }
    }

    public function detail($id = 0)
    {
        $info = IndexModel::where('id', $id)->find();
        if ($info) {
            return json($info);
        } else {
            return json(['error' => '数据不存在'], 404);
        }
    }
}
