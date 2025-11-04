<?php
namespace app\controller;
use app\BaseController;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\LocalFile;
use danog\MadelineProto\ParseMode;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;


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
        $file_id = 'AgACAgUAAxkBAAIXfWkJsVzDBfSjgZKoUFF5ra2WFaRGAAICDGsbJkhJVImkTYpUa_RCAQADAgADeAADNgQ';

        $file_path =realpath(public_path().'/2025050804415560.webp');

        if ($file_path === false || !file_exists($file_path)) {
            die('文件不存在或路径错误：' . $file_path);
        }
        $media = new LocalFile($file_path);

        $caption = 'xx这是图片的说';
        try {

            $result = $MadelineProto->messages->sendMedia([
                'peer' => $peer_id,
                'media' => $media,
                'caption' => $caption,
            ]);
            $result = $MadelineProto->messages->sendMedia([
                'peer' => $peer_id,
                'media' => $file_path,
                'caption' => $caption,
            ]);
         
            echo "图片消息已发送！";
        } catch (\Exception $e) {
            echo '发送失败：', $e->getMessage();
        }

//            $MadelineProto->messages->sendMessage([
//                'peer' => $peer_id,
//                'message' => $caption,
//            ]);

    }
}
?>