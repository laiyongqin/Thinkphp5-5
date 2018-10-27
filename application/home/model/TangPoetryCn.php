<?php
// +----------------------------------------------------------------------
// | lifves [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 https://www.lifves.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Firstmeet·初见 <1834537260@qq.com>
// +----------------------------------------------------------------------

namespace app\home\model;

use think\Model;
use think\facade\Request;

/**
 * 唐诗(中文简体)模型
 * @author Firstmeet·初见 <1834537260@qq.com>
 */
class TangPoetryCn extends Model
{
    protected $table = 'lf_tang_poetry-zh-cn';

    /**
     * 获取列表数据
     * @author Firstmeet·初见 <1834537260@qq.com>
     */
    public static function getList($where = array(), $limit = 10, $page = 1)
    {
        if ($page) {
            $data_list = self::where($where)->paginate($limit, false, ['query' => Request::param()]);
        } else {
            $data_list = self::where($where)->limit($limit)->select();
        }
        return $data_list;
    }
}
