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
        //$session_file = runtime_path(). 'session.madeline';
        $session_file = 'session.madeline';
        $MadelineProto = new API($session_file, $settings);

        try {
            $MadelineProto->start(); // 首次运行会提示验证

        } catch (Exception $e) {
            echo 'Error: ', $e->getMessage();
            exit;
        }

        $peer_id = -4919097926;
        $media = 'AgACAgUAAxkBAAIXKGkIZCJvkTW1daOPqWge_BnQqQUVAALfC2sbH5BAVNv6BbNlE-o5AQADAgADcwADNgQ';
        $MadelineProto->messages->sendMedia([
            'peer' => $peer_id,
            'media' => $media,
            'caption' => '图片说明'
        ]);

    }


}
