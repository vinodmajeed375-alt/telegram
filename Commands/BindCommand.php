<?php
namespace Commands;
use app\controller\Api;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use think\facade\Log;


class BindCommand  extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'bind';

    /**
     * @var string
     */
    protected $description = '商户绑定';

    /**
     * @var string
     */
    protected $usage = '/bind <location>';

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
        $chat_id = $message->getChat()->getId();   // Get the current Chat
        $param["id"]= $this->getConfig('id'); //群ID
        $param["title"]= $this->getConfig('title');//群名称
        $param["uid"]= $this->getConfig('uid'); //商户尖
        Log::write($param,'BindCommand');
        $msg = Api::bind($param);
        $data = [
            'chat_id' => $chat_id,
            'text'    => $msg,
        ];
        return Request::sendMessage($data);        // Send message!
    }
}
