<?php
namespace app\controller;

use app\BaseController;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use think\facade\Log;
class Hook extends BaseController
{

    public function index()
    {
        try {
            // Create Telegram API object
            $telegram = new Telegram($this->config['api_key'], $this->config['bot_username']);
            // Handle telegram webhook request
            $telegram->handle();
            //$telegram->enableMySql($this->config['mysql']);
            $telegram->addCommandsPaths($this->config['commands']['paths']);
            // Add commands paths containing your custom commands
            $updates = file_get_contents('php://input');
            Log::write($updates,'Hook');
            $ojb =  new Tg($this->app);
            $ojb->index($telegram,$updates);
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // Silence is golden!
            Log::write($e->getMessage(),'Hook-index-error');
            $e->getMessage();
        }
    }
    public function telegramSet(){
        try {
            Log::write($this->config['webhook']['url'],'Hook telegramSet');
            // Create Telegram API object
            $telegram = new Telegram($this->config['api_key'], $this->config['bot_username']);
            // Set webhook
            $result = $telegram->setWebhook($this->config['webhook']['url']);
            //$result = $telegram->setWebhook($this->config['webhook']['url'],['certificate' => '/www/wwwroot/telegram.abcbpay.com/ssl/public_key.pem']);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
            echo $e->getMessage();
            Log::write($e->getMessage(),'hook Set');
        }
    }

    public function telegramUnset(){
        Log::write($this->config['api_key'],'Hook telegramUnset');
        try {
            // Create Telegram API object
            $telegram = new Telegram($this->config['api_key'], $this->config['bot_username']);
            // Unset / delete the webhook
            $result = $telegram->deleteWebhook();
            echo $result->getDescription();
        } catch (TelegramException $e) {
            Log::write($e->getMessage(),'hook Unset');
            $e->getMessage();
        }
    }


}
