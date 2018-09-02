<?php

namespace App\Service\Face;

use Exception;

class Face{
    
    protected $config;
    
    /**
     *
     * @var type \App\Service\Contract\Faceplusplus\FaceInterface
     */
    protected $drives = array();
    
    protected $driveIndex = '';

    public function __construct($faceConfig) {
        
        $this->config = $faceConfig;
        
        $this->driveIndex =  $faceConfig['default'];
          
        $this->factory($this->driveIndex);
    }
    
    
    public function mergeface($year,$avatar){
        return $this->getDrive()->mergeface($this->getTemplate($year),$avatar);
    }

        /**
     * 
     * @param type $driveIndex
     * @return \App\Service\Contract\Faceplusplus\FaceInterface
     */   
    public function getDrive($driveIndex = null){
        return $this->factory($driveIndex?:$this->driveIndex);
    }
    
    public function driveIndex(){
        return $this->driveIndex;
    }

    /**
     * 
     * @param type $driveIndex
     * @return \App\Service\Contract\Faceplusplus\FaceInterface
     * @throws Exception
     */
    protected function factory($driveIndex){
        if(isset($this->drives[$driveIndex])){
            $this->driveIndex = $driveIndex;
            return $this->drives[$driveIndex];
        }
        
        if(!isset($this->config['drives']) && isset($this->config['drives'][$driveIndex])){
            throw new Exception("App\Service\Face\Faceplusplus\Face:drives {$driveIndex} not exisit");
        }
        //$this->config['drives'][$driveIndex]
        switch ($driveIndex){
            case 'faceplusplus':
                $this->drives[$driveIndex] = new Faceplusplus\FaceplusplusFace($this->config['drives'][$driveIndex]);
                break;
            case 'youtu':
                $this->drives[$driveIndex] = new Youdu\YouduFace($this->config['drives'][$driveIndex]);
        }
        if(!isset($this->drives[$driveIndex])){
            throw new Exception("App\Service\Face\Faceplusplus\Face:drives {$driveIndex} not exisit");
        }
        
        $this->driveIndex = $driveIndex;
        
        return $this->drives[$driveIndex];
        
    }

    public function __call($name, $arguments) {
        return $this->getDrive()->{$name}(...$arguments);
    }
    
    /**
     * 获取模板
     * @param type $year
     * @return type
     */
    public function getTemplate($year){
        return $this->config['template'][$this->driveIndex][$year];
    }
    

 
}










