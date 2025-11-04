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
        $media = 'AgACAgUAAxkBAAIXKGkIZCJvkTW1daOPqWge_BnQqQUVAALfC2sbH5BAVNv6BbNlE-o5AQADAgADcwADNgQ'; // 媒体ID
        $caption = '图片说明';

        // 先确保目标聊天已加载（用 getChats()）
        try {
            // 获取目标聊天信息，确保它存在
            $chats = $MadelineProto->getChat($peer_id);
           // $chats = $MadelineProto->getChats([$peer_id]);
            if (!isset($chats[$peer_id])) {
                throw new \Exception("目标聊天不存在或未导入");
            }
        } catch (Exception $e) {
            echo '获取聊天信息失败：', $e->getMessage(), "\n";
            exit;
        }

        // 发送媒体消息
        try {
            $MadelineProto->messages->sendMedia([
                'peer' => $peer_id,
                'media' => $media,
                'caption' => $caption,
            ]);
            echo "消息已发送！";
        } catch (Exception $e) {
            echo '发送消息失败：', $e->getMessage();
        }
    }
}
?>