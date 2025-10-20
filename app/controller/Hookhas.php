<?php
namespace app\controller;
use app\BaseController;
use danog\MadelineProto\API;

class Hookhas extends BaseController
{
    public function index()
    {
        $settings = [
            'api_id' => YOUR_API_ID,            // 从my.telegram.org获取 absweb188114
            'api_hash' => 'YOUR_API_HASH',      // 从my.telegram.org获取  dbed93369_123
        ];
        $session_file = 'session.madeline';
        $MadelineProto = new API($session_file, $settings);
        try {
            $MadelineProto->start(); // 首次运行会提示验证
        } catch (\danog\MadelineProto\Exception $e) {
            echo 'Error: ', $e->getMessage();
            exit;
        }

      //持续监听新消息（简单轮询）
        while (true) {
            //获取未读取的消息
            $updates = $MadelineProto->getUpdates(['limit' => 10]);
            foreach ($updates as $update) {
                if (isset($update['update']['_']) && $update['update']['_'] === 'updateNewMessage') {
                    $msg = $update['update']['message'];
                    $peer = $msg['peer_id'];
                    // 只处理群组消息
                    if (isset($peer['_']) && in_array($peer['_'], ['peerChat', 'peerChannel'])) {
                        $chat_peer = $peer;
                        $message_text = $msg['message'] ?? '';
                        // 简单示例：检测是否为订单查询命令
                        if (strpos($message_text, '!订单') !== false) {
                            // 解析订单号（假设为示例）
                            $parts = explode(' ', $message_text);
                            $order_id = $parts[1] ?? '';
                            // 查询订单（此处调用你的订单查询逻辑）
                            $order_status = getOrderStatus($order_id); // 自定义函数
                            // 回复消息
                            $reply_text = "订单 $order_id 状态：$order_status";
                            $MadelineProto->messages->sendMessage([
                                'peer' => $msg['peer_id'],
                                'message' => $reply_text,
                                'reply_to_msg_id' => $msg['id'],
                            ]);
                        }
                    }
                }
            }
            // 休眠一段时间，避免频繁请求
            sleep(2);
        }

    }

    //自定义订单查询逻辑（示例函数）
   public function getOrderStatus($order_id) {
        // 这里你可以连接数据库或调用API
        // 示例返回静态状态
        return '已发货';
    }

}
