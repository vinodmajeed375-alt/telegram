<?php
namespace Commands;
use app\controller\Api;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;



class DfCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'df';

    /**
     * @var string
     */
    protected $description = '代付查单';

    /**
     * @var string
     */
    protected $usage = '/df <location>';

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
        $param["orderid"]= $this->getConfig('orderid');
        $msg = Api::getDfOrder($param);
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $msg, // Set message to send
        ];
        return Request::sendMessage($data);        // Send message!
    }
}
