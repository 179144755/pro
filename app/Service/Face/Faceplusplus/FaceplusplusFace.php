<?php

namespace App\Service\Face\Faceplusplus;

use App\Service\Contract\Faceplusplus\FaceInterface;

class FaceplusplusFace implements FaceInterface{
    
    /**
     *
     * @var \App\Service\Face\Faceplusplus\Faceplusplus
     */
    protected $faceplusplus = null;
    
    protected $faceBlendingTemplate = null;


    public function __construct($config) {
        $this->faceplusplus = new Faceplusplus($config);
    }

    public function mergeface($template_base64, $merge_base64) {
        return $this->faceplusplus->mergeface($template_base64, $merge_base64);
    }
    
    /**
     * 
     * @return \App\Service\Face\Faceplusplus\Faceplusplus
     */
    public function getFaceplusplus(){
        return $this->faceplusplus;
    }

}
