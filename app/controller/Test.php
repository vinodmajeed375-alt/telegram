<?php


namespace app\controller;


class Test
{

    public function ss(){
        $str = '{"update_id":405717044,"message":{"message_id":5869,"from":{"id":6193520154,"is_bot":false,"first_name":"鲁班九号","username":"luban1990","language_code":"zh-hans"},"chat":{"id":-4858717700,"title":"10258\/印度一类","type":"group","all_members_are_administrators":true,"accepted_gift_types":{"unlimited_gifts":false,"limited_gifts":false,"unique_gifts":false,"premium_subscription":false}},"date":1761990940,"photo":[{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADcwADNgQ","file_unique_id":"AQADPQxrGwtGMFR4","file_size":835,"width":42,"height":90},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADbQADNgQ","file_unique_id":"AQADPQxrGwtGMFRy","file_size":11329,"width":148,"height":320},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADeAADNgQ","file_unique_id":"AQADPQxrGwtGMFR9","file_size":38436,"width":369,"height":800},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADeQADNgQ","file_unique_id":"AQADPQxrGwtGMFR-","file_size":61644,"width":590,"height":1280}],"caption":"ust2025110116323119870"}}';
       $arr =  json_decode($str,true)['message'];
       var_dump($arr['photo'][0]['file_id']);
        //var_dump($arr['chat']);

        $str='{"update_id":405717045,"message":{"message_id":5870,"from":{"id":6193520154,"is_bot":false,"first_name":"鲁班九号","username":"luban1990","language_code":"zh-hans"},"chat":{"id":-4663428801,"title":"test105","type":"group","all_members_are_administrators":true,"accepted_gift_types":{"unlimited_gifts":false,"limited_gifts":false,"unique_gifts":false,"premium_subscription":false}},"date":1761991039,"photo":[{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADcwADNgQ","file_unique_id":"AQADPQxrGwtGMFR4","file_size":835,"width":42,"height":90},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADbQADNgQ","file_unique_id":"AQADPQxrGwtGMFRy","file_size":11329,"width":148,"height":320},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADeAADNgQ","file_unique_id":"AQADPQxrGwtGMFR9","file_size":38436,"width":369,"height":800},{"file_id":"AgACAgUAAxkBAAIW62kF16UNcVdkKTItGB_WKQ2LNJpsAAI9DGsbC0YwVLLNRIYZEu6kAQADAgADeQADNgQ","file_unique_id":"AQADPQxrGwtGMFR-","file_size":61644,"width":590,"height":1280}],"caption":"utr3423423432"}}';
        $arr =  json_decode($str,true)['message'];
        var_dump($arr['photo'][0]);
       //var_dump($arr['chat']);
        exit;
    }
    function setWebhook($url, $certificate) {
        // 这里应该是你的 API 请求代码
        // 例如，使用 cURL 发送 POST 请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://telegram.abcbpay.com/test/bbb.html');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'url' => $url,
            'certificate' => $certificate
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

     public function index(){

         $apiToken = '7619626384:AAGsN79BWYLMbXDguTO1Kh0vOa7hYopOeQw'; // 替换为你的Bot Token
         $chatId = '-4891216419'; // 群组用户名，或者群组ID（注意：ID需要带负号，例如 -1001234567890）
         $last_update_id = 0;
         while (true) {
             $url = "https://api.telegram.org/bot$apiToken/getUpdates?offset=$last_update_id";

             $response = file_get_contents($url);
             $updates = json_decode($response, true);

             if ($updates['ok']) {
                 foreach ($updates['result'] as $update) {
                     $last_update_id = $update['update_id'] + 1;

                     if (isset($update['message'])) {
                         $message = $update['message'];

                         // 检查是否有新成员加入
                         if (isset($message['new_chat_members'])) {
                             foreach ($message['new_chat_members'] as $member) {
                                 // 如果机器人是新成员
                                 if ($member['id'] == YOUR_BOT_ID) {
                                     $chat_id = $message['chat']['id'];
                                     $chat_title = isset($message['chat']['title']) ? $message['chat']['title'] : '';

                                     // 记录群ID（存入数据库或文件）
                                     echo "加入的群组ID: $chat_id, 标题: $chat_title\n";
                                 }
                             }
                         }
                     }
                 }
             }
             sleep(1); // 防止频繁请求
         }

     }
}