<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;


use Exception;

class UserController extends CommonController
{       
    
    public function center(){
       return view('web.user_center',array('user'=> $this->getUser()));
    }
    
    public function user(){
        return $this->getUser();
    }
    
    
}
