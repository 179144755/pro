<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\WebConfig;
use Exception;

class WebConfigController extends CommonController {

    //get.admin/quiz 全部题库
    public function index() {
        $data = WebConfig::orderBy('id', 'desc')->paginate(10);
        return view('admin.webconfig.index', compact('data'));
    }

    /**
     * 图片组
     */
    protected function templete_type_2($webConfig) {
        return view('admin.webconfig.add_img_array', compact('webConfig'));
    }

    /**
     * 图片
     */
    protected function templete_type_1($webConfig) {
        return view('admin.webconfig.add_img', compact('webConfig'));
    }

    public function getValue($id) {
        $webConfig = WebConfig::find($id);
        if ($webConfig->type == 2) {
            $webConfig->value = json_decode($webConfig->value, true) ?: array();
        }
        return $webConfig->value;
    }

    public function edit($id) {
        $webConfig = WebConfig::find($id);

        $templete = 'templete_type_' . $webConfig->type;

        return $this->$templete($webConfig);
    }

    public function upload_img($name = '') {

        $name = $name ?: request()->input('name', 'webconfig');


        $path = $this->uploadImg('img', date('YmdHis') . '_' . $name);
        if (!$path) {
            throw new Exception('保存失败!#2');
        }
        return $path;
    }

    public function save($id) {
        try {
            $webConfig = WebConfig::find($id);

            if ($webConfig->type == 2) {
                $webConfig->value = json_encode(request()->input('value'));
                return $webConfig->save() ? array('message' => '保存成功') : array('message' => '保存失败');
            } else {
                $path = $this->upload_img(date('YmdHis') . '_' . $webConfig->name);
                $webConfig->value = $path['url'];
            }

            if (!$webConfig->save()) {
                throw new Exception('保存失败!');
            }

            $webConfig->value && file_exists($webConfig->value) && unlink($webConfig->value);

            return redirect('admin/webconfig/index');
        } catch (Exception $e) {
            if ($e->getCode() == 0) {
                return back()->with('errors', $e->getMessage());
            }
            throw $e;
        }
    }

}
