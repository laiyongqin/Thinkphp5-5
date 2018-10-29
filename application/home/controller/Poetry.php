<?php
// +----------------------------------------------------------------------
// | lifves [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 https://www.lifves.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Firstmeet·初见 <1834537260@qq.com>
// +----------------------------------------------------------------------

namespace app\home\controller;

use app\home\model\AnalectsCn as AnalectsCnModel;
use app\home\model\BookOfSongsCn as BookOfSongsCnModel;
use app\home\model\IpGpsRelation as IpGpsRelationModel;
use app\home\model\SongPoetryCn as SongPoetryCnModel;
use app\home\model\TangPoetryCn as TangPoetryCnModel;
use think\Controller;
use think\facade\Request;

class Poetry extends Controller
{
    /**
     * 默认方法
     * @author Firstmeet·初见 <1834537260@qq.com>
     */
    public function index()
    {
    	$mb = Request::instance()->isMobile() ? 1 : 0;
    	$log = Request::instance()->server('HTTP_USER_AGENT').'手机'.$mb;
    	file_put_contents('../runtime/test.txt', $log);
        $where = array();
        $type  = array(
            '1' => '唐诗',
            '2' => '宋词',
            '3' => '论语',
            '4' => '诗经',
        );
        if (Request::has('type', 'get')) {
            $type_get = Request::param('type');
            switch ($type_get) {
                case '1':
                    $list = TangPoetryCnModel::getList($where);
                    break;
                case '2':
                    $list = SongPoetryCnModel::getList($where);
                    break;
                case '3':
                    $list = AnalectsCnModel::getList($where, 5);
                    break;
                case '4':
                    $list = BookOfSongsCnModel::getList($where);
                    break;
                default:
                    $list = TangPoetryCnModel::getList($where);
                    break;
            }
        } else {
            $list = TangPoetryCnModel::getList($where);
        }
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('page', $page);

        $this->assign('meta_title', '古诗词');
        return $this->fetch();
    }

    /**
     * 获取天气
     * @author Firstmeet·初见 <1834537260@qq.com>
     */
    public function getWeather()
    {
        $type = Request::post('type');
        if ($type) {
            $dataInfo = '';
            $data     = array();
            switch ($type) {
                case 'city':
                    $dataInfo = Request::post('city');
                    break;
                case 'gps':
                    $dataInfo = Request::post('gps');
                    break;
                default:
                    break;
            }
            if ($dataInfo) {
                $weather = getWeather($type, $dataInfo);
                if ($weather) {
                    $weather = json_decode($weather, true);
                    if ($weather['status'] && $weather['info'] == 'OK') {
                        $data['status']   = 1;
                        $data['province'] = $weather['lives']['0']['province'];
                        $data['city']     = $weather['lives']['0']['city'];
                        $data['weather']  = $weather['lives']['0']['weather'];
                        if ($type == 'gps') {
                            $data['district'] = $weather['lives']['0']['district'];
                            //存储访问者的IP、GPS、位置、天气信息以及设备信息
                            IpGpsRelationModel::addInfo(['ip' => Request::instance()->ip(), 'gps' => $dataInfo, 'location' => $data['province'] . $data['city'] . $data['district'], 'weather' => $data['weather'], 'device' => Request::instance()->server('HTTP_USER_AGENT'), 'is_mobile' => Request::instance()->isMobile() ? 1 : 0]);
                        }
                    } else {
                        $data['status'] = 0;
                    }
                } else {
                    $data['status'] = 0;
                }
            } else {
                $data['status'] = 0;
            }
        } else {
            $data['status'] = 0;
        }
        return json($data);
    }
}
