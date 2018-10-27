<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 根据城市获取天气
 * @author Firstmeet·初见 <1834537260@qq.com>
 */
use app\home\model\GdMapCityCode as GdMapCityCodeModel;
use QL\QueryList;

function getWeather($type = '', $data = '')
{
    $result = '';
    switch ($type) {
        case 'city':
            // 城市名称转为adcode
            $citycode = GdMapCityCodeModel::getCityCode($data);
            $result   = getWeatherInfo($citycode);
            break;
        case 'gps':
            // 获取adcode用来查询天气
            $gpsInfo = getGpsInfo($data);
            if ($gpsInfo) {
                $gpsInfo = json_decode($gpsInfo, true);
                if ($gpsInfo['status'] && $gpsInfo['info'] == 'OK') {
                    $citycode = $gpsInfo['regeocode']['addressComponent']['adcode'];
                    $weather  = getWeatherInfo($citycode);
                    $weather  = json_decode($weather, true);
                    if ($weather['status'] && $weather['info'] == 'OK') {
                        $weather['lives']['0']['city']     = $gpsInfo['regeocode']['addressComponent']['city'];
                        $weather['lives']['0']['district'] = $gpsInfo['regeocode']['addressComponent']['district'];
                    }
                    $result = json_encode($weather);
                }
            }
            break;
        default:
            break;
    }
    return $result;
}

// 查询天气
function getWeatherInfo($adcode)
{
    $result = '';
    if ($adcode) {
        $url    = '//restapi.amap.com/v3/weather/weatherInfo';
        $key    = '3ceb0363058710bc4e10c20143177377';
        $result = QueryList::get($url, [
            'key'  => $key,
            'city' => $adcode,
        ])->getHtml();
    }
    return $result;
}

// GPS定位
function getGpsInfo($gps)
{
    $result = '';
    if ($gps) {
        $url    = '//restapi.amap.com/v3/geocode/regeo';
        $key    = '3ceb0363058710bc4e10c20143177377';
        $result = QueryList::get($url, [
            'key'      => $key,
            'location' => $gps,
        ])->getHtml();
    }
    return $result;
}
