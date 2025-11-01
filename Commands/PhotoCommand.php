<?php
namespace Commands;
use app\controller\Api;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use think\facade\Log;


class PhotoCommand  extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'photo';

    /**
     * @var string
     */
    protected $description = '发上游查单';

    /**
     * @var string
     */
    protected $usage = '/photo <location>';

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
        $param = $this->getConfig();
       // $param["orderid"]= $this->getConfig('orderid');
        //Log::write($this->getConfig(),'photo config');
        $msg =  "已经收到查单反馈，请耐心等候结果";
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $msg, // Set message to send
            'reply_to_message_id'=>$param['message_id']
        ];
        //$this->parentMessage($param);
        Log::write($data,'photo remsg');
        return Request::sendMessage($data); // 回复查单消息
    }

    public function parentMessage($param){
        $photo = end($param['photo']); //获取最高分辨率的图片
        $file_id = $photo['file_id'];
        $msg ='查询单号不存在';
        $pchatid = $param['pchatid'];
        if(!empty($param['userid']) && !empty($param['caption'])){
            $orderinfo = Api::getOrderArray(['uid'=>$param['userid'],'orderid'=>$param['caption']]);
            Log::write($orderinfo,'photo orderinfo');
            if( !empty($orderinfo['pay_up_trade_no'])){
                $msg = $orderinfo['pay_up_trade_no'];
                $tginfo =  Api::getPayChannl($orderinfo['channel_id']);
                Log::write($tginfo,'photo pay_channel');
                $pchatid = $tginfo['zfb_pid'];
            }
        }
        Request::sendPhoto([
            'chat_id' =>  $pchatid, //父类群主ID
            'photo' => $file_id, //直接用file_id
            'caption' => $msg,
        ]);
    }
}
