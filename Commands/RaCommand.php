<?php
namespace Commands;
use app\controller\Api;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use think\facade\Log;


class RaCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'ra';

    /**
     * @var string
     */
    protected $description = '成功率';

    /**
     * @var string
     */
    protected $usage = '/ra <location>';

    /**
     * @var string
     */
    protected $version = '1.3.0';

    /**
     * Base URI for OpenWeatherMap API
     *
     * @var string
     */

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();            // Get Message object
        $chat_id = $message->getChat()->getId();   // Get the current Chat ID
        $param["uid"]= $this->getConfig('userid');
       // $param["orderid"]= $this->getConfig('orderid');
        $msg = Api::getRate($param);
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $msg, // Set message to send
        ];
        Log::write(json_encode($data,JSON_UNESCAPED_UNICODE),'Ra execute sendMessage');
        return Request::sendMessage($data);        // Send message!
    }
}
