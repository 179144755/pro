<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Model\Video;
use App\Http\Model\Notice;
use App\Http\Model\Quiz;
use App\Http\Model\Member;
use App\Http\Model\MemberDrugPhoto;
use App\Http\Model\MemberVanguard;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends CommonController
{       
    
    public function center(){
       return view('web.user_center',array('user'=> $this->getUser()));
    }
    
    
}
