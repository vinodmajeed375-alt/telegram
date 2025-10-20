<?php
namespace app\controller;
use app\BaseController;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use think\facade\Log;
class Hookquery extends BaseController
{
    public function index()
    {
        try {
            $telegram = new Telegram($this->config['api_key_q'], $this->config['bot_username_q']);
            $telegram->handle();
            $updates = file_get_contents('php://input');
            Log::write($updates,'Hook_query');
            $ojb =  new Tg($this->app);
            $ojb->index($telegram,$updates);
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            Log::write($e->getMessage(),'Hook-index-error');
            $e->getMessage();
        }
    }
    public function telegramSet(){
        try {
            Log::write($this->config['webhook']['urlquery'],'Hook_query  telegramSet');
            $telegram = new Telegram($this->config['api_key_q'], $this->config['bot_username_q']);
            $result = $telegram->setWebhook($this->config['webhook']['urlquery']);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
            Log::write($e->getMessage(),'hook Set');
        }
    }

    public function telegramUnset(){
        try {
            $telegram = new Telegram($this->config['api_key_q'], $this->config['bot_username_q']);
            $result = $telegram->deleteWebhook();
            echo $result->getDescription();
        } catch (TelegramException $e) {
            Log::write($e->getMessage(),'hook Unset');
            $e->getMessage();
        }
    }
}
