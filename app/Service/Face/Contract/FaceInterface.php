<?php


namespace App\Service\Face\Contract;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Administrator
 */
interface FaceInterface {
        
    /**
     * 
     * @param type $template
     * @param type $merge
     */
    public function mergeface($template,$merge);

}
