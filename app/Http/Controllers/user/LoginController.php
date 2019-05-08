<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * 展示视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('user/login');
    }

    /**
     * 登录执行
     * @param Request $request
     */
    public function loginDo(Request $request){
        $u=$request->input('u');
        $p=$request->input('p');

        $where=[
            'user_name'=>$u,
        ];
        $data=DB::table('user_test')->where($where)->first();




        if($data){
            $user_pwd=$data->user_pwd;
            $uid=$data->user_id;

            $token=$this->token($uid);

            $key_token="token$uid";

            Redis::set($key_token,$token);
            Redis::expire($key_token,60*24*24*7);


            if(password_verify($p,$user_pwd)){

                setcookie('token',$token,time()+200,'/','1809api.com',false,true);
                setcookie('uid',$uid,time()+200,'/','1809api.com',false,true);

                header('Refresh:3;url=http://passport.1809api.com');
                $res=[
                    'code'=>200,
                    'msg'=>'登录成功'
                ];
                return json_encode($res,JSON_UNESCAPED_UNICODE);
            }else{
                header("refresh:3;url=/loginindex");
                $res=[
                    'code'=>40003,
                    'msg'=>'账号或密码错误'
                ];
                return json_encode($res,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $res=[
                'code'=>40005,
                'msg'=>'此用户不存在'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *生成token
     * @param $uid
     * @return string
     */
    public function token($uid){
        return substr(sha1(Str::random(11).md5("lisi")),5,15)."uid".$uid;
    }
}