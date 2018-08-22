<?php

namespace App\Http\Controllers\Web;

class IndexController extends CommonController
{
    public function index()
    {
        return view('web.index');
    }
    
    public function dpxq(){
        return view('web.jindu_dpxq');
    }
    
    public function gz(){
        return view('web.jindu_gz');
    }
    
    public function jd(){
        return view('web.jindu_jd');
    }
    
    public function rs(){
        return view('web.jindu_rs');
    }
    
    public function xc(){
        return view('web.jindu_xc');
    }
    
    public function xddl(){
        return view('web.jindu_xddl');
    }
}
