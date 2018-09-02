<?php

namespace App\Service\Face\Youdu;

use App\Service\Face\Contract\FaceInterface;

class YouduFace implements FaceInterface{
    
    /**
     *
     * @var \App\Service\Face\Youdu\Youdu
     */
    protected $youdu = null;
    

    public function __construct($config) {
        $this->youdu = new Youdu($config);
    }

    public function mergeface($template, $merge) {
        $img_data = base64_encode(file_get_contents($merge));
        return $this->youdu->doFaceMerge($img_data, $template);
    }
    
    /**
     * 
     * @return \App\Service\Face\Faceplusplus\Faceplusplus
     */
    public function getFaceplusplus(){
        return $this->youdu;
    }

}
