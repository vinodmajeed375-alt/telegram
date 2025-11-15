<?php
namespace Commands;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ServerResponse;
use think\facade\Log;


class TestCommand extends UserCommand
{
    protected $name = 'test';                      // Your command's name
    protected $description = 'A command for test'; // Your command description
    protected $usage = '/test';                    // Usage of your command
    protected $version = '1.0.0';                  // Version of your command
    public function execute(): ServerResponse
    {
        Log::write("Test start",'TestCommand');
        $message = $this->getMessage();            // Get Message object
        if($message && $message->getChat()){
            $chat_id = $message->getChat()->getId();
            Log::write($message,'TestCommand');
            Log::write($chat_id,'TestCommand chat_id');
            $msg = "输入命令错误：\r\n /zf xxxxy代收订单号 \r\n /df xxxxy代付订单号\r\n /ba 余额查询\r\n /ra 成功率查询";
            $data = [                                  // Set up the new message data
                'chat_id' => $chat_id,                 // Set Chat ID to send the message to
                'text'    => $msg, // Set message to send
            ];
            return Request::sendMessage($data);        // Send message!
        }

    }
}