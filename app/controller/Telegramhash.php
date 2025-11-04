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




        $peer_id = -4919097926; // 目标群组或频道ID

        $media = 'https://cdn.pixabay.com/photo/2025/10/17/15/16/halloween-9900545_1280.jpg'; // 图片文件路径或URL，也可以是媒体ID
        $caption = '这是图片的说明';

        try {
            $chats = $MadelineProto->getChat($peer_id);
            if (!isset($chats)) {
                throw new \Exception("目标聊天未导入");
            }
        } catch (\Exception $e) {
            echo '导入聊天失败：', $e->getMessage(), "\n";
            exit;
        }

        try {
            $MadelineProto->messages->sendMedia([
                'peer' => $peer_id,
                'media' => $media,
                'caption' => $caption,
            ]);

            $MadelineProto->messages->sendMedia([
                'peer' => -4724604306,
                'media' => $media,
                'caption' => $caption,
            ]);


            echo "图片消息已发送！";
        } catch (\Exception $e) {
            echo '发送失败：', $e->getMessage();
        }


    }
}
?>