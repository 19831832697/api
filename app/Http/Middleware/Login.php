<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        $user_id=$request->input('user_id');

        if(empty($token) || empty($user_id)){
            $res=[
                'errno'=>40003,
                'msg'=>'参数不全'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        $key="token$user_id";
        $local_token=Redis::get($key);
        if($token){
            if($token == $local_token){
                //记录日志
            }else{
                $res=[
                    'errno'=>40020,
                    'msg'=>'不合法的token'
                ];
                die(json_encode($res,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $res=[
                'errno'=>40009,
                'msg'=>'请先登录'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        return $next($request);
    }
}
