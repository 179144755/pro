<?php

namespace App\Service\Face\Faceplusplus;

use Exception;

class Faceplusplus {

    protected $api_secret = '';
    protected $api_key = '';
    
    
    public function __construct($config = array()) {
        if(isset($config['api_secret'])){
            $this->api_secret = $config['api_secret'];
        }
        
        if(isset($config['api_key'])){
            $this->api_key = $config['api_key'];
        }
    }

    /**
     * 可以对模板图和融合图中的人脸进行融合操作。融合后的图片中将包含融合图中的人脸特征，以及模板图中的其他外貌特征与内容。
     * https://console.faceplusplus.com.cn/documents/20813963
     * @param type $template_base64 用于人脸融合的模板图
     * @param type $merge_base64 用于人脸融合的融合图
     * @param type $merge_rate 融合比例，范围 [0,100]。数字越大融合结果包含越多融合图 (merge_url, merge_file, merge_base64 代表图片) 特征。默认值为50
     */
    public function mergeface($template_base64, $merge_base64, $merge_rate = 30) {
        $data['template_base64'] = $template_base64;
        $data['merge_base64'] = $merge_base64;
        $data['merge_rate'] = $merge_rate;
        
        //$detectResult = $this->detect($merge_base64);
        //$faceRectangle = $detectResult['face_rectangle'];
        //指定融合图中用以融合的人脸框位置。 四个正整数，用逗号分隔，依次代表人脸框左上角纵坐标（top），左上角横坐标（left），人脸框宽度（width），人脸框高度（height）。例如：70,80,100,100
        //$data['merge_rectangle'] = implode(',', array($faceRectangle['top'],$faceRectangle['left'],$faceRectangle['width'],$faceRectangle['height']));
        
        $templeteDetectResult = $this->detect($template_base64);
        $templeteFaceRectangle = $templeteDetectResult['face_rectangle'];
        $data['template_rectangle'] = implode(',', array($templeteFaceRectangle['top'],$templeteFaceRectangle['left'],$templeteFaceRectangle['width'],$templeteFaceRectangle['height']));
        
        $response = $this->curl('https://api-cn.faceplusplus.com/imagepp/v1/mergeface', $data);
        return $response['result'];
    }

    /** 
     * 传入图片进行人脸检测和人脸分析。
     * https://console.faceplusplus.com.cn/documents/4888373
     * @param type $image_base64 base64 编码的二进制图片数据
     * @param type $return_attributes 是否检测并返回根据人脸特征判断出的年龄、性别、情绪等属性。合法值为：
     * @param type $return_landmark
     */
    public function detect($image_base64, $return_attributes = 'none', $return_landmark = 0) {

        $data['image_base64'] = $image_base64;
        $data['return_attributes'] = $return_attributes;
        $data['return_landmark'] = $return_landmark;
        
        $response = $this->curl('https://api-cn.faceplusplus.com/facepp/v3/detect', $data);

        return $response['faces'][0];
    }
    
    protected function curl($curl_url,$data) {
        $requestData['api_key'] = $this->api_key;
        $requestData['api_secret'] = $this->api_secret;
        $requestData = array_merge($requestData,$data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curl_url, //输入URL
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
             CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $requestData, 
            CURLOPT_HTTPHEADER => array("cache-control: no-cache",),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("curl error Faceplusplus:{$err}");
        }
        
        $response = json_decode($response,true);
        if (!$response) {
            throw new Exception("curl error Faceplusplus:return error".$curl_url);
        }
        if(isset($response['error_message']) && $response['error_message']){
            throw new Exception($response['error_message'].$curl_url);
        }
        return $response;
    }

    

}
