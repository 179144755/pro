<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Model\Video;
use App\Http\Model\Notice;
use App\Http\Model\Quiz;
use App\Http\Model\Member;
use App\Http\Model\WebConfig;
use App\Http\Model\MemberDrugPhoto;
use App\Http\Model\MemberVanguard;
use Illuminate\Support\Facades\DB;
use Exception;

class IndexController extends CommonController {

    public function index(Request $request) {
        return view('web.index', array('active' => 'home'));
    }

    public function config(Request $request) {
        $name = $request->input('name', array('advertising', 'drug_face'));

        $object = new \stdClass();

        $data = WebConfig::whereIn('name', (array) $name)->get();

        foreach ($data as $row) {
            $object->{$row->name} = array('value' => $row->value, 'type' => $row->type);
        }

        return json_encode($object);
    }

    public function dpxq($id) {
        $notice = Notice::find((int) $id);
        if (!$notice) {
            throw new Exception('来错地方拉');
        }
        $notice->increment('reading_volume');
        return view('web.jindu_dpxq', compact('notice'));
    }

    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf() {
        $user = $this->getUser();
        $memberVanguard = MemberVanguard::where('member_id', $user->id)->first();
        if ($memberVanguard) {
            return $this->jdxf_show();
        }
        return view('web.jindu_jdxf', array('active' => 'first'));
    }

    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_list(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $data = MemberVanguard::orderBy('id', 'desc')->paginate(10);
            return $data;
        }
        return view('web.jindu_jdxf_list', array('active' => 'first'));
    }

    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_show($memberVanguard = null) {
        if (!$memberVanguard) {
            $user = $this->getUser();
            $memberVanguard = MemberVanguard::where('member_id', $user->id)->first();
        }
        if (!$memberVanguard) {
            throw new Exception('来错地方拉');
        }
        return view('web.jindu_jdxf_show', array('memberVanguard' => $memberVanguard, 'active' => 'first'));
    }

    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_upload(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();

            if (MemberVanguard::where('member_id', $user->id)->first()) {
                throw new Exception('非法上传', -100);
            }

            $filename = $user->id . '_0_' . date('YmdHis');
            $name = '';
            $path = $this->upload('img', $filename, '/vanguard_avatar');
            if (!$path) {
                throw new Exception('上传失败');
            }
            try {
                $index = 2;
                $base64Url = app('face')->mergeface($index, $path['path']);
                $extension = ltrim($path['entension'], '.');
                $imgPathData = $this->saveImg(base64_decode($base64Url), $user->id . "_{$index}_" . date('YmdHis') . '.' . $extension, '/vanguard_avatar');

                $id = MemberVanguard::create(array(
                            'member_id' => $user->id,
                            'name' => $name,
                            'img' => $path['url'],
                            'drug_img' => $imgPathData['url'],
                            'create_time' => date('Y-m-d H:i:s')
                ));
                if (!$id) {
                    throw new Exception('上传失败');
                }
                return array(
                    'id' => $id,
                    'img' => $path['url'],
                    'drug_img' => $imgPathData['url'],
                );
            } catch (Exception $e) {
                unlink($path['path']);
                isset($imgPathData) && $imgPathData && unlink($imgPathData['path']);
                throw $e;
            }
        }
        throw new Exception('你来错了哦');
    }

    /**
     * 公告
     * @return type
     */
    public function gz(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $type = $request->input('type', 1);
            $data = Notice::orderBy('id', 'desc')->where('type', $type)->paginate(10);

            foreach ($data as $notice) {
                $notice->increment('reading_volume');
            }

            return $data;
        }
        return view('web.jindu_gz', array('active' => 'work'));
    }

    /**
     * 在线竞答
     * @return type
     */
    public function jd(Request $request) {

        if ($request->isXmlHttpRequest()) {
            $data = Quiz::orderBy('id', 'asc')->paginate(1);
            return $data;
        } else {
            $request->session()->put('jd_begin', time());
        }
        return view('web.jindu_jd');
    }

    public function jd_answer(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $jd_begin = $request->session()->get('jd_begin');
            $jd_end = time();
            $jd_use = $jd_end - $jd_begin;

            $answer = (array) $request->input('answers');
            $quizs = Quiz::all('id', 'answer');

            $correct = 0;
            $error = 0;
            foreach ($quizs as $quiz) {
                if (!isset($answer[$quiz->id])) {
                    continue;
                }
                if ($answer[$quiz->id] == $quiz->answer) {
                    $correct++;
                } else {
                    $error++;
                }
            }
            return array(
                'use_time' => $jd_use,
                'use_time_format' => floor($jd_use / 60) . '分' . ($jd_use % 60) . '秒',
                'correct' => $correct,
                'error' => $error,
                'fraction' => $correct * 5
            );
        }
        throw new Exception('你来错了哦');
    }

    /**
     * 
     * 认识毒品
     * @param Request $request
     * @return type
     */
    public function rs(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $field = array('id', 'title', 'tag', 'create_time', 'short_content');
            $type = $request->input('type', 3);

            $data = Notice::orderBy('id', 'desc')->where('type', $type)->paginate(10);
            return $data;
        }
        return view('web.jindu_rs', array('active' => 'eye'));
    }

    /**
     * 视频宣传
     * @return type
     */
    public function xc(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $data = Video::orderBy('id', 'desc')->whereIn('type',array(1,2))->paginate($request->input('size', 10));
            return $data;
        }
        return view('web.jindu_xc');
    }

    public function xddl(Request $request) {
        return view('web.jindu_xddl');
    }

    public function xddl_upload(Request $request) {
        if ($request->isXmlHttpRequest()) {
            if (!$request->file('drug_avatar')->isValid()) {
                throw new Exception('非法图片');
            }

            if ($request->file('drug_avatar')->getSize() > 1024 * 1024 * 2) {
                throw new Exception('超过2M');
            }

            $path = $this->upload('drug_avatar', '', '/drug_avatar', 'linux');
            if (!$path) {
                throw new Exception('上传失败');
            }

            return array(
                'year_imgs' => array(),
                'no_drug_avatar' => $path['url'],
                'path' =>  $path['path'],
            );
        }

        throw new Exception('你来错了哦');
    }

    public function xd_year(Request $request) {

        $index = $request->input('year');
        $filename = $request->input('filename');
        $entension = substr(strrchr($filename, '.'), 1 );
        
        $indexs = (array)$index;
        
        foreach ($indexs as $index) {
            $base64Url = app('face')->mergeface($index, $filename);
            $filename = uniqid(date('Ymd') . '_') . '.' . $entension;
            $imgPathData = $this->saveImg(base64_decode($base64Url), $filename, '/drug_avatar', array('height' => 120, 'width' => 120));
            $year_imgs[] = array('year' => $index, 'photo' => $imgPathData['url']);
        }
        return array(
            'year_imgs' => $year_imgs,
        );
    }

    public function like_num(Request $request) {
        $id = (int) $request->input('id');
        return array(
            'like_num' => Notice::where('id', $id)->increment('like_num')
        );
    }

    public function jddt_start() {
        return view('web.jindu_jddt_start');
    }

    public function test() {

        //$merge_base64 = base64_encode(file_get_contents(base_path('resources/views/web/images/camera_1.png')));
        //$template_base64 = base64_encode(file_get_contents(app('face_templete')(2)));
        //IMG_FILTER_SELECTIVE_BLUR

//
//        $a = 'E:\application\zintao\backend\branches\dev\1.jpg';
//        $b = 'E:\application\zintao\backend\branches\dev\2.jpg';
//        $c = '/tmp/1.jpeg';



//        $srcImg = imagecreatefromstring($a);
//        $srcWidth = imagesx($srcImg);
//        $srcHeight = imagesy($srcImg);
//        //创建新图
//        $newWidth = round($srcWidth / 1);
//        $newHeight = round($srcHeight / 1);
//        $newImg = imagecreatetruecolor($newWidth, $newHeight);
//        //分配颜色 + alpha，将颜色填充到新图上
////        $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
////        imagefill($newImg, 0, 0, $alpha);
//        
//        //将源图拷贝到新图上，并设置在保存 PNG 图像时保存完整的 alpha 通道信息
//        imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
//        imagesavealpha($newImg, true);
//        imagejpeg($newImg,$destfile);
//            
//            
//            
//         $img = imagecreatefromjpeg($a);
//        
//         imagefilter($img,IMG_FILTER_SELECTIVE_BLUR);
//         
//         imagejpeg($img,$b);
        //exit;
//        $result = app('face')->mergeface(4, $c);
        
        $result = array();
        
        
        //var_dump($result);

        return view('test', array('face_tow_img' => $result));
    }

}
