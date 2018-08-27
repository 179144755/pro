<?php

namespace App\Service\Face;


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
        
        switch ($driveIndex){
            case 'faceplusplus':
                $this->drives[$driveIndex] = new Faceplusplus\Faceplusplus($this->config['drives'][$driveIndex]);
                break;
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
    

 
}










