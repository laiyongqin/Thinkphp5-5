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

/**
 * IP、GPS关系模型
 * @author Firstmeet·初见 <1834537260@qq.com>
 */
class IpGpsRelation extends Model
{
    protected $table              = 'lf_ip_gps_relation';
    protected $autoWriteTimestamp = true;
    protected $insert             = ['status' => 1];

    /**
     * 添加访问者IP以及GPS信息
     * @author Firstmeet·初见 <1834537260@qq.com>
     */
    public static function addInfo($data = array())
    {
        $num = self::where(['ip' => $data['ip']])->count();
        if ($num === 3) {
            // 查询出最老的数据id
            $id = self::where(['ip' => $data['ip']])->limit(1)->order('update_time', 'asc')->value('id');
            // 更新
            self::update($data, ['id' => $id]);
        } else {
            self::create($data);
        }
    }
}
