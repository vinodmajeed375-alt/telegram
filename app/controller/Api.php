<?php
namespace app\controller;
use app\BaseController;
use GuzzleHttp\Client;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Log;

class Api extends BaseController
{
    public static function  getDomin(){
        $config = config('cms');
        return $config['api_domain'];
    }
    public static function getOrder($input){
        $url = self::getDomin().'/Pay_Trade_query.html';
        $param["pay_memberid"]=$input['uid'];;
        $param["pay_orderid"]=$input['orderid'];
        $param["pay_md5sign"]="9999";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params'=>$param
        ]);
        $body = (string)$response->getBody();
        $data = json_decode($body,true);
        $msg = "---订单信息---\r\n";
        if(!empty($data['orderid'])){
            $msg = "---订单信息---\r\n";
            $msg .= "平台单号:{$data['transaction_id']}\r\n";
            $msg .= "状态:{$data['trade_state']}\r\n";
            $msg .= "商户单号:{$data['orderid']}\r\n";
            $msg .= "创建时间:{$data['create_time']}\r\n";
            $msg .= "支付时间:{$data['time_end']}\r\n";
        }else{
            $msg .= "订单号错误或数据不存在";
        }
        return $msg;
    }
    public static function getOrderArray($input){
        $url = self::getDomin().'/Pay_Trade_querytg.html';
        $param["pay_memberid"]=$input['uid'];
        $param["pay_orderid"]=$input['orderid'];
        $param["pay_md5sign"]="9999";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params'=>$param
        ]);
        $body = (string)$response->getBody();
        $data = json_decode($body,true);
        return $data;
    }

    public static function getBalance($input){
        $url = self::getDomin().'/Payment_Dfpay_balance.html';
        $param["mchid"]=$input['uid'];;
        $param["pay_md5sign"]="9999";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params'=>$param
        ]);
        $body = (string)$response->getBody();
        $data = json_decode($body,true);
        $msg = "---商户信息---\r\n";
        if(!empty($data['mchid'])){
            $msg = "---商户信息---\r\n";
            $msg .= "用户名:{$data['username']}\r\n";
            $msg .= "商户号:{$data['mchid']}\r\n";
            $msg .= "余额:{$data['balance']}\r\n";
            $msg .= "冻结余额:{$data['blockedbalance']}\r\n";
        }else{
            $msg .= "商户号错误或未绑定";
        }
        return $msg;
    }
    public static function getRate($input){
        $url = self::getDomin().'/home_Telegram_successRate.html';
        $param["mchid"]=$input['uid'];;
        $param["pay_md5sign"]="9999";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params'=>$param
        ]);
        $body = (string)$response->getBody();
        $data = json_decode($body,true);
        $msg = "---支付成功率信息---\r\n";
        if(!empty($data['mchid'])){
            $msg = "---支付成功率信息---\r\n";
            $msg .= "今日成功率:{$data['rate']}\r\n";
            $msg .= "今日成功金额:{$data['pay_amount']}\r\n";
            $msg .= "今日失败金额:{$data['fail_amount']}\r\n";
            $msg .= "今日成功笔数:{$data['success_count']}\r\n";
            $msg .= "今日失败笔数:{$data['fail_count']}\r\n";
            $msg .= "今日总订单笔数:{$data['order_count']}\r\n";
        }else{
            $msg .= "商户号错误或未绑定";
        }
        return $msg;
    }

    public static function getPayChannl($mchid){
        $key = "pay_channel_id{$mchid}";
        $info = Cache::get($key);
        if(true || !$info){
            $url = self::getDomin().'/home_Telegram_getPayChannel.html';
            $param["mchid"]= $mchid;
            $client = new Client();
            $response = $client->request('POST', $url, [
                'verify' => false,
                'form_params'=>$param
            ]);
            $body = (string)$response->getBody();
            $info = json_decode($body,true);
            Cache::set($key,$info);
        }
        return $info;
    }

    public static function getDfOrder($input){
        $url = self::getDomin().'/Payment_Dfpay_querytg.html';
        $param["mchid"]=$input['uid'];;
        $param["out_trade_no"]= $input['orderid'];
        $param["pay_md5sign"]="9999";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params'=>$param
        ]);
        $body = (string)$response->getBody();
        $data = json_decode($body,true);
        $data['success_time'] = !empty($data['success_time'])?$data['success_time']:"";
        $msg = "---代付信息---\r\n";
        if(!empty($data['out_trade_no'])){
            $msg = "---订单信息---\r\n";
            $msg .= "平台单号:{$data['transaction_id']}\r\n";
            $msg .= "状态:{$data['refMsg']}\r\n";
            $msg .= "商户单号:{$data['out_trade_no']}\r\n";
            $msg .= "提交时间:{$data['create_time']}\r\n";
            $msg .= "完成时间:{$data['success_time']}\r\n";
        }else{
            $msg .= "代付单号错误或数据不存在";
        }
        return $msg;
    }
    public static function getChannl($chat){
         $key = (string)$chat['id'];
         $info = Cache::get($key);
         if(!$info){
             $info = Db::name('channl')->where(['id'=>$chat['id']])->find();
              Cache::set($key,$info,150);
         }
         return $info;
    }

    public static function bind($chat){
        $info = Db::name('channl')->where(['id'=>$chat['id']])->find();
        $data['uid']= $chat['uid'];
        $data['title']= $chat['title'];
        $key = (string)$chat['id'];
        Cache::delete($key);
        if($info){
           $rs =   Db::name('channl')->where(['id'=>$chat['id']])->update($data);
        }else{
            $data['id']= $chat['id'];
            $data['pchatid']= "";
            $rs =  Db::name('channl')->insert($data);
        }
        Log::write($data,'data api bind');
        $msg = !empty($rs)?'商户绑定ID:'.$chat['uid']:"商户绑定失败";
        return $msg;
    }
}