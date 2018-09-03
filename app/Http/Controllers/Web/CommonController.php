<?php

namespace App\Http\Controllers\Web;


use App\Http\Model\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class CommonController extends Controller
{   
    protected $user = null;
    
    public function getUser(){
        return Member::find(1);
    }
    
    /**
     *  图片上传
     * @param type $index
     * @param string $filename
     * @param type $dir
     * @return boolean|string
     */
    public function upload($index='image',$filename='',$dir='')
    {
        $file = Input::file($index);
        if(!$file -> isValid()){
            return false;
        }
        
        if(!$filename){
            $filename = date('YmdHis').mt_rand(100,999);
        }      
        $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        $newName = $filename.'.'.$entension;
        $path = $file -> move(base_path().'/uploads'.$dir,$newName);
        
        return array(
            'path'=>$path->getPathname(),
            'file_name'=>$path->getFilename(),
            'url'=>"/uploads{$dir}/{$newName}",
            'entension' => $entension,
            'attach'=>''
        );
    }
    
    /**
     * 
     * @param type $data
     * @param type $filename
     * @param type $dir
     * @return boolean
     */
    public function saveImg($data,$filename,$dir=''){        
        $path = base_path().'/uploads'.$dir.'/'.$filename;
        if(!file_put_contents($path, $data)){
            return false;
        }
        
        return array(
            'path' => $path,
            'url' => "/uploads{$dir}/{$filename}"
        );
    }
    
    public function getRealPathByUrl($url){
        return base_path() . $url;
    }
    
    public function imgMoreSmall($filename,$percent=0.5){
        list($width, $height, $type) = getimagesize($filename);
        $extension = ltrim(image_type_to_extension($type),'.');
        // 获取新的尺寸
        $new_width = $width * $percent;
        $new_height = $height * $percent;
        // 重新取样
        $image_p = imagecreatetruecolor($new_width, $new_height);
        
        $imagecreatefrom = 'imagecreatefrom'.$extension;
        
        $image = $imagecreatefrom($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        // 输出
        
        $input_image = 'image'.$extension;
        
        $input_image($image_p, $filename);
        return $filename;
    }
    
    public function imgSoupot($imgFormat){
        return array(
            'png' => array('from' =>'imagecreatefrompng','to'=>'imagepng'),
            'jpeg' => array('from' =>'imagecreatefromjpeg','to'=>'imagejpeg'),
            'gif' => array('from' =>'imagecreatefromgif','to'=>'imagegif'),
            'bmp' => array('from' =>'imagecreatefrombmp','to'=>'imagebmp'),
        );
    }
    
    
    public function checkImg($filename) {
        $imageinfo = array();
        $size = getimagesize($filename,$imageinfo);
       
//        if($size > ){
//            
//        }
        
        
        
    }
    
    
}
