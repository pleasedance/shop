<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3
 * Time: 17:11
 */

class WxHelper
{
    //获取微信AccessToken
    public static function getAccessToken(){
        $access_token = \App\Data\WxAccessTokenData::info();
        if ($access_token){
            return $access_token;
        }
        $getAccessTokenUrl = config("company.getAccessToken");
        $getAccessTokenUrl = str_replace(["APPID","APPSECRET"],[config("company.appid"),config("company.appsecret")],$getAccessTokenUrl);
        $curl = new \JSocket();
        $curl->setUrl($getAccessTokenUrl);
        $curl->setRetFormat(\JSocket::retFormatJson);
        $curl->setTimeout(30);
        $curl->setMethod(\JSocket::methodGet);
        $curl->exe();
        $r = $curl->getRet();
        return \App\Data\WxAccessTokenData::set($r["access_token"],$r["expires_in"]);
    }

    /**
     * seedTempMessage 发送模板消息
     * @author DaiChong
     * @DateTime 2019-01-04
     * @param    array      $seedData    需要发送的数据 格式为(key=>value)
     * @param    string     $tempKey     tempkey
     * @return   json
     * @demo     array(
     *               'touser'      => 'openid',
     *               'template_id' => '模板id',//可以为空
     *               'page'        => '跳转地址',//可以为空
     *               'form_id'     => 'form_id',//不可为空
     *               'keyword1'=> '消息内容',//
     *               'keyword2'=> '消息内容1',
     *                   ...............
     *           )
     */
    public static function seedTempMessage($seedData,$tempKey)
    {
        if( empty($seedData) ){
            self::seedError('请传输数据(格式为Array)！');
            return;
        }

        //发送模板消息地址
        $postUrl = config("company.seedTempMeg");
        if( $postUrl == false ){
            self::seedError('未定义微信模板消息地址(seedTempMeg)！');
            return;
        }

        if($tempKey){
            //查询消息模板内容
            $temp = \App\Models\WechatMessageModel::where('temp_key',$tempKey)->first()->toArray();
            if( empty($temp) ){
                self::seedError('未添加此模板!');
                return;
            }
            $seedData['template_id'] = $temp['temp_id'];
            $temp_context = $temp['context'];
            $temp_json = vsprintf($temp_context,$seedData);

            $temp_array = json_decode($temp_json,true);
            //获取AccessToken
            $accessToken = self::getAccessToken();
            $postUrl = str_replace('ACCESS_TOKEN', $accessToken, $postUrl);
            $curl = new \JSocket();
            $curl->setUrl($postUrl);
            $curl->setRetFormat(\JSocket::retFormatText);
            foreach ($temp_array as $key => $value) {
                $curl->setParam($key,$value);
            }
            $curl->setTimeout(30);
            $curl->setHeader("Content-Type:application/json");
            $curl->setRequestType(\JSocket::retFormatJson);
            $curl->setMethod(\JSocket::methodPost);
            $curl->exe();
            $result = $curl->getRet();
            self::seedError($result);
            return $result;
        }else{
            self::seedError('未传入模板Key(tempKey)!');
            return;
        }
    }
    //发送失败
    public static function seedError($msg){
        \Log::info($msg);
        return \ResponseHelper::success([
            'code'    => 1,
            'message' => $msg
        ]);
    }

    /**
     * 微信支付签名
     * @param unknown $data
     * @param unknown $key
     * @return string
     */
    static public function sign($data,$key)
    {
        ksort($data);
        reset($data);
        $data['key'] = $key;
        $temp = [];
        foreach ($data as $k=>$v)
        {
            if ($v != '' && !in_array($k, ['sign']))
            {
                $temp[] = ($k.'='.$v);
            }
        }
        $string = implode('&', $temp);
        return strtoupper(md5($string));
    }
}