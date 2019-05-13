<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * curl接口
     */
    public function curl(){
        $url="http://www.b_test.com/register";
        $data=[
            'user_name'=>'zhangsan',
            'user_pwd'=>'12345'
        ];
        $post_str="name=lisi&pwd=3333";
        $arr=json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
//        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_str);
        //json格式
//        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
//        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $res=curl_exec($ch);
        print_r($res);
    }

    public function show(){
        $ip=$_SERVER['REMOTE_ADDR'];
        $key="ip_list";
        $init=Redis::incr($key);
        Redis::set($key,$ip);

        echo $init;die;
        if($init>=5){
            die('调用频繁，一分钟后重试');
        }
        echo "<br/>";
        echo $init;
        Redis::expire($key,10);
    }

    /**
     * 注册接口
     * @param Request $request
     * @return false|string
     */
    public function register(Request $request){
        $user_name=$request->input('user_name');
        $user_pwd=$request->input('user_pwd');
        $repwd=$request->input('repwd');
        $user_email=$request->input('user_email');
        $user_age=$request->input('user_age');

        if($user_pwd!=$repwd){
            return json_encode(['code'=>50001,'msg'=>'两次密码不一致']);
        }

        $data=DB::table('user_test')->where('user_email',$user_email)->first();
        if(!empty($data)){
            return json_encode(['code'=>50002,'msg'=>'邮箱已存在'],JSON_UNESCAPED_UNICODE);
        }
        $userPwd=password_hash($user_pwd,PASSWORD_BCRYPT);
        $arrInfo=[
            'user_name'=>$user_name,
            'user_pwd'=>$userPwd,
            'user_email'=>$user_email,
            'user_age'=>$user_age,
            'create_time'=>time(),
        ];
        $arr=DB::table('user_test')->insert($arrInfo);
        if($arr){
            return json_encode(['code'=>0,'msg'=>'注册成功'],JSON_UNESCAPED_UNICODE);
        }else{
            return json_encode(['code'=>50004,'msg'=>'注册失败'],JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 登录接口
     * @param Request $request
     * @return false|string
     */
    public function login(Request $request){
        $user_name=$request->input('user_name');
        $user_pwd=$request->input('user_pwd');
        $where=[
            'user_name'=>$user_name,
        ];

        $arrInfo=DB::table('user_test')->where($where)->first();
        $user_id=$arrInfo->user_id;
        $uname=$arrInfo->user_name;
        $pwd=$arrInfo->user_pwd;

        if(empty($uname)){
            return json_encode(['code'=>50006,'msg'=>'账号不存在'],JSON_UNESCAPED_UNICODE);
        }else if(password_verify($user_pwd,$pwd)){

            $token=$this->token($user_id);
            $key_token="token$user_id";
            Redis::set($key_token,$token);
            Redis::expire($key_token,60*24*24*7);

            return json_encode(['code'=>0,'msg'=>'登录成功','token'=>$token]);
        }else{
            return json_encode(['code'=>50005,'msg'=>'密码错误'],JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 生成token
     */
    public function token($user_id){
        return substr(sha1(Str::random(11).md5("lisi")),5,15)."user_id".$user_id;
    }

    /**
     * 用户中心
     */
    public function my(){
        echo 555;
    }

}
