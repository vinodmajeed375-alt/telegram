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
            'api_id' => 21952672,
            'api_hash' => '013d3f03edf22c8800b8b47937458ef1',
        ]);
        $session_file = runtime_path(). 'session.madeline';
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
