<?php
namespace app\controller;
use app\BaseController;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\LocalFile;
use danog\MadelineProto\ParseMode;
use danog\MadelineProto\RemoteUrl;
use danog\MadelineProto\BotApiFileId;
use danog\Decoder\FileId;
use think\App;


class Telegramhash extends BaseController
{


    public function index($file_id,$msg)
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

        $str = ' {"update_id":405717298,"message":{"message_id":6217,"from":{"id":6193520154,"is_bot":false,"first_name":"鲁班九号","username":"luban1990","language_code":"zh-hans"},"chat":{"id":-4663428801,"title":"test105","type":"group","all_members_are_administrators":true,"accepted_gift_types":{"unlimited_gifts":false,"limited_gifts":false,"unique_gifts":false,"premium_subscription":false}},"date":1762417090,"photo":[{"file_id":"AgACAgUAAxkBAAIYSWkMWcIsDJE9mnjJHGyz4aa2lJXSAAIeDGsbbWtgVCwR3sCfLAJOAQADAgADcwADNgQ","file_unique_id":"AQADHgxrG21rYFR4","file_size":1409,"width":90,"height":60},{"file_id":"AgACAgUAAxkBAAIYSWkMWcIsDJE9mnjJHGyz4aa2lJXSAAIeDGsbbWtgVCwR3sCfLAJOAQADAgADbQADNgQ","file_unique_id":"AQADHgxrG21rYFRy","file_size":17981,"width":320,"height":213},{"file_id":"AgACAgUAAxkBAAIYSWkMWcIsDJE9mnjJHGyz4aa2lJXSAAIeDGsbbWtgVCwR3sCfLAJOAQADAgADeAADNgQ","file_unique_id":"AQADHgxrG21rYFR9","file_size":74486,"width":800,"height":533},{"file_id":"AgACAgUAAxkBAAIYSWkMWcIsDJE9mnjJHGyz4aa2lJXSAAIeDGsbbWtgVCwR3sCfLAJOAQADAgADeQADNgQ","file_unique_id":"AQADHgxrG21rYFR-","file_size":137230,"width":1280,"height":853}],"caption":"wwww111"}}';
        $file_rs = json_decode($str,true)['message']['photo'][3];
       // $file_id = $file_rs['file_id'];

        $file_path = realpath(public_path().'/q1.jpg');
        $caption = 'xx这是图片的说ss1';
        try {

           // $file = new LocalFile($file_id);

           // $BotApiFileId =  new BotApiFileId($file_rs['file_id'],$file_rs['file_size'],$file_rs['file_id'],true);

            $media = [
                '_' => 'inputMediaUploadedPhoto',
                'file' => $file_path
            ];

            //$fileId = FileId::fromBotAPI($file_id);

//            $media = [
//                '_' => 'inputMediaPhoto',
//                'id' => $file_id
//            ];

            $MadelineProto->messages->sendMedia([
                'peer' => $peer_id, // 目标对话的Peer对象或ID
                'media' => $media,
                'message' => $msg, // 可选
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

    public function tt(){
        if (!file_exists('madeline.php')) {
            copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
        }
        include 'madeline.php';

        $MadelineProto = new \danog\MadelineProto\API('session.madeline');
        $MadelineProto->start();

        $Updates = $MadelineProto->messages->sendMedia(silent: $Bool, background: $Bool, clear_draft: $Bool, noforwards: $Bool, update_stickersets_order: $Bool, invert_media: $Bool, allow_paid_floodskip: $Bool, peer: $InputPeer, reply_to: $InputReplyTo, media: $InputMedia, message: 'string', reply_markup: $ReplyMarkup, entities: [$MessageEntity, $MessageEntity], parse_mode: 'string', schedule_date: $int, send_as: $InputPeer, quick_reply_shortcut: $InputQuickReplyShortcut, effect: $long, allow_paid_stars: $long, suggested_post: $SuggestedPost, );

    }
}
?>