<?php
namespace app\home\model;

use think\Model;

/**
 * 高德地图城市code模型
 * @author Firstmeet·初见 <1834537260@qq.com>
 */
class GdMapCityCode extends Model
{
    protected $table = 'lf_gd_map_city_code';

    /**
     * 根据名称获取城市code
     * @author Firstmeet·初见 <1834537260@qq.com>
     */
    public static function getCityCode($name = '')
    {
        $where = [
            ["title", "like", "%" . $name . "%"],
        ];
        return self::where($where)->value('adcode') ?: '';
    }
}
