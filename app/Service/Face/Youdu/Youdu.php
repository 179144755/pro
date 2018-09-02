<?php

namespace App\Service\Face\Youdu;

use Exception;

class Youdu{

    protected $appID = '';
    protected $secretID = '';
    protected $secretKey = '';
    protected $qq = '';
    
    
    public function __construct($config = array()) {
        if(isset($config['appID'])){
            $this->appID = $config['appID'];
        }
        
        if(isset($config['secretID'])){
            $this->secretID = $config['secretID'];
        }
        
        if(isset($config['secretKey'])){
            $this->secretKey = $config['secretKey'];
        }
        
        if(isset($config['qq'])){
            $this->qq = $config['qq'];
        }
        
    }
    
    /**
     * http://open.youtu.qq.com/legency/#/develop/api-makeup-image
     * @param type $img_data
     * @param type $model_id
     */
    public function doFaceMerge($img_data,$model_id){
        $data = array(
            'img_data' => $img_data,
            'app_id' => $this->appID,
            'rsp_img_type' => 'base64',
            'opdata' => array(array('cmd'=>'doFaceMerge','params'=>array('model_id'=>$model_id))),
        );
        $response = $this->curl('http://api.youtu.qq.com/cgi-bin/pitu_open_access_for_youtu.fcg', $data);
        
        if($response['ret']!=0){            
            throw new Exception($this->getMessageByError($response['ret']),$response['ret']); 
        }
        
        return $response['img_base64'];
    }
    
    public function getSignStr(){
        $singArr = array(
            'u' => $this->qq,
            'a' => $this->appID,
            'k' => $this->secretID,
            't' => time(),
            'e' => time() + 30,
            'r' => 1234567890,
            'f'=>''
        );
        $orignal =  http_build_query($singArr);
        $signStr = base64_encode(hash_hmac('sha1', $orignal, $this->secretKey, true).$orignal);
        return $signStr;
    } 
    
    protected function curl($curl_url,$data) {
        $requestData = json_encode($data);

        $length = strlen($requestData);
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $curl_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $requestData,
          CURLOPT_HTTPHEADER => array(
            "Authorization: {$this->getSignStr()}",
            "Cache-Control: no-cache",
            "Content-Length: {$length}",
            "Content-Type: application/json",
            "Host: api.youtu.qq.com",
            "Postman-Token: 24ddf68d-3c35-49c8-b7ba-f6ab1e022381"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
           throw new Exception("cURL Error #:" . $err); 
        }
        
        $response = json_decode($response,true);
        
        if(!$response){
            throw new Exception("cURL $curl_url Error  #: 返回错误数据"); 
        }
        return $response;
    }
    
    public function getMessageByError($code){
        $error = array(
                '1000'=>'无人脸',
                '-1000'=>'参数错误',
                '-1001'=>'图像处理错误',
                '-1002'=>'读写CKV出错',
                '-1003'=>'读写REDIS出错',
                '-1004'=>'保存结果图片出错',
                '-1005'=>'下载用户图片出错',
                '-1007'=>'服务器内部逻辑出错',
                '-1008'=>'人脸检测失败',
                '-1009'=>'参数拼接不规范',
                '-2102'=>'图片操作功能不存在',
                '-2103'=>'图片操作功能无权限',
                '-2093'=>'命令字权限错误',
                '-2094'=>'签名不匹配',
                '-2095'=>'secret', 'id'=>'不匹配',
                '-2096'=>'查询appid对应信息失败',
                '-2097'=>'签名过期',
                '-2098'=>'original字段获取失败',
                '-2099'=>'签名无效',
                '-2100'=>'http头错误',
                '-2102'=>'图片处理功能不存在',
                '-2103'=>'图片操作功能无权限',
        );
        
        if(isset($error[$code])){
            return $error[$code];
        }
        
        if($code>=-2101 && $code<=-2093){
            return '接口调用鉴权失败';
        }
        
                
        if($code>=-2011 && $code<=2015){
            return '访问频率超出限制';
        }
        
        return '未知错误';
        
        
    }
    

}
