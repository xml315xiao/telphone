<?php

namespace app;
use libs\CURL;
use libs\MyRedis;

class MobileQuery
{

    const PHONE_API = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm';

    const PHONE_QUERY = 'PHONE:INFO:';

    public static function query($phone)
    {
        $data = NULL;
        if (FALSE !== self::verifyPhone($phone) ) {
            $redis_key = sprintf(self::PHONE_QUERY . '%s', $phone);
            $phone_info = MyRedis::getRedis()->get($redis_key);
            if (strlen($phone_info) < 1){
                $curl = new CURL();
                $response = $curl->get(self::PHONE_API, array('tel'=>$phone));
                $data = self::formatData($response);
                if (sizeof($data) > 0) {
                    MyRedis::getRedis()->set($redis_key, json_encode($data));
                }
                $data['message'] = '该数据由阿里巴巴提供';
            } else {
                $data = json_decode($phone_info, TRUE);
                $data['message'] = '该数据由本站提供';
            }
        }
        return $data;
    }

    public static function verifyPhone($phone)
    {
        require_once API. '/libs/validator_helper.php';
        return check_format($phone, 'mobile');
    }

    public static function formatData($data)
    {
        $result = null;
        if (!empty($data)) {
            preg_match_all("/(\w+):'([^']+)/", $data, $res);
            $result = array_combine($res[1], $res[2]);
        }
        return $result;
    }
}