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
        
        $this->driveIndex =  $faceConfig['deault'];
          
        $this->factory($this->driveIndex);
    }
    
    
    public function factory($driveIndex){
        if(isset($this->drives[$driveIndex])){
            $this->driveIndex = $driveIndex;
            return $this->drives[$driveIndex];
        }
        
        if(!isset($this->config['drive']) && isset($this->config['drive'][$driveIndex])){
            throw new Exception("App\Service\Face\Faceplusplus\Face:drives {$driveIndex} not exisit");
        }
        
        switch ($driveIndex){
            case 'faceplusplus':
                $this->drives[$driveIndex] = new Faceplusplus\Faceplusplus($this->config['drive'][$driveIndex]);
                break;
        }
        
        if(!isset($this->drives[$driveIndex])){
            throw new Exception("App\Service\Face\Faceplusplus\Face:drives {$driveIndex} not exisit");
        }
        
        $this->driveIndex = $driveIndex;
        
        return $this->drives[$driveIndex];
        
    }
    
    public function getDrive(){
        
    }

    
    //public function 

















}










