<?php
namespace app\controller;
use app\BaseController;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;

class Telegramhash extends BaseController
{
    public function index()
    {
        $settings = new Settings([
            'api_id' => 24397383,
            'api_hash' => '00b548fa7f78dde0fbf2e5ca318d4303',
        ]);
        $session_file = 'session.madeline'; // 会话文件路径
        $MadelineProto = new API($session_file, $settings);

        try {
            $MadelineProto->start(); // 启动会话，首次运行会提示验证
        } catch (Exception $e) {
            echo 'Error: ', $e->getMessage();
            exit;
        }




        $peer_id = -4663428801; // 目标群组或频道ID

        $file_id = 'AgACAgUAAxkBAAIXfWkJsVzDBfSjgZKoUFF5ra2WFaRGAAICDGsbJkhJVImkTYpUa_RCAQADAgADeQADNgQ'; // 图片文件路径或URL，也可以是媒体ID
        $file_id = 'AgACAgUAAxkBAAIXfWkJsVzDBfSjgZKoUFF5ra2WFaRGAAICDGsbJkhJVImkTYpUa_RCAQADAgADeAADNgQ';


//        $upload = $MadelineProto->upload([
//            'file' => public_path() . '/luotuo-001.jpg',
//            //'file' => 'https://img.ivsky.com/img/tupian/t/202108/25/luotuo-001.jpg',
//        ]);
//
//        // 获取正式的file_id
//        $file_info = $MadelineProto->getFile($upload['file_id']);
//        $file_id = $file_info['file_id'];
//
//        var_dump($file_id);


        $caption = 'xx这是图片的说';

//        try {
//            $chats = $MadelineProto->getChat($peer_id);
//            if (!isset($chats)) {
//                throw new \Exception("目标聊天未导入");
//            }
//        } catch (\Exception $e) {
//            echo '导入聊天失败：', $e->getMessage(), "\n";
//        }

        try {

//            $MadelineProto->messages->sendMessage([
//                'peer' => $peer_id,
//                'message' => $caption,
//            ]);

            $MadelineProto->messages->sendMedia([
                'peer' => $peer_id,
                'media' => $file_id,
                'caption' => $caption,
            ]);

            $MadelineProto->messages->sendMedia([
                'peer' => -4724604306,
                'media' => $file_id,
                'caption' => $caption,
            ]);


            echo "图片消息已发送！";
        } catch (\Exception $e) {
            echo '发送失败：', $e->getMessage();
        }


    }
}
?>