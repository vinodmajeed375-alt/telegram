<?php
namespace app\controller;

use app\BaseController;
use think\App;
use think\facade\Db;
use think\facade\Log;
use Longman\TelegramBot\Request;

class Tg extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }
    public function lists(){
        $list = Db::name('message')->field("chat_id,user_id,text,id")->select();
        if($list){
               $ids = [];
            foreach ($list as $key=>$value){
                $commd = explode(" ",$value['text']);
                $arr['id'] = $value['chat_id'];
                $channl = Api::getChannl($arr);
                $msg = "";
                switch ($commd[0]){
                    case '/zf':
                            $msg = Api::getOrder(['uid'=>$channl['uid'],'orderid'=>$commd[1]]);
                        break;
                    case '/df':
                        $msg = Api::getDfOrder(['uid'=>$channl['uid'],'orderid'=>$commd[1]]);
                        break;
                    case '/ba':
                        $msg = Api::getBalance(['uid'=>$channl['uid']]);
                        break;
                    case '/bind':
                        break;
                    default:
                }
                if(empty($msg)){
                    $msg = "支付查询: /zf xxxx\r\n代付查询: /df xxxx\r\n余额查询: /ba\r\n";
                }
                $ids[] = $value['id'];
                $this->senMsg($value['chat_id'],$msg);
            }

            Db::name('telegram_update')->where(['message_id'=>$ids])->delete();
            Db::name('message')->where(['id'=>$ids])->delete();
        }
    }

    public function index(&$telegram="",$chat=""){
          $chat_arr = json_decode($chat,true);
          Log::write($chat,'tg index');
          $arr = [];
          if(isset($chat_arr['edited_message'])){
              $arr = $chat_arr['edited_message'];
          }elseif(isset($chat_arr['message'])){
              $arr = $chat_arr['message'];
          }elseif(isset($chat_arr['my_chat_member'])){
              $arr = $chat_arr['my_chat_member'];
          }
          $channl = Api::getChannl($arr['chat']);
            if(empty($channl['uid'])){
                Log::write($channl,'channl');
                return ;
            }
          if(!empty($arr['photo'])){
              $arr['userid'] = $channl['uid'];
              $arr['pchatid'] = $channl['pchatid'];
              $telegram->setCommandConfig('photo',$arr);
              $telegram->runCommands(['/photo']);
              exit;
          }
          $commd = [];
          $commd_b = "";
          if(isset($arr['text']) && !empty($arr['text'])){
              $commd = preg_split('/\s+/',$arr['text']);
              $commd_b = trim($commd[0]);
          }
          switch ($commd_b){
              case '/zf':
                  if(isset($commd[1])){
                      $telegram->setCommandConfig('zf',['userid'=>$channl['uid'],'orderid'=>$commd[1]]);
                      $telegram->runCommands(['/zf']);
                  }
              break;
              case '/df':
                  if(isset($commd[1])) {
                      $telegram->setCommandConfig('df', ['userid' => $channl['uid'], 'orderid' => $commd[1]]);
                      $telegram->runCommands(['/df']);
                  }
              break;
              case '/ba':
                  $telegram->setCommandConfig('ba',['userid'=>$channl['uid'],'orderid'=>""]);
                  $telegram->runCommands(['/ba']);
                  break;
              case '/ra':
                  $telegram->setCommandConfig('ra',['userid'=>$channl['uid']]);
                  $telegram->runCommands(['/ra']);
                  break;
              case '/bind':
                  if(isset($commd[1])) {
                      if(isset($chat_arr['message']['chat']['id']) && isset($chat_arr['message']['chat']['title'])){
                          $telegram->setCommandConfig('bind',['id'=>$chat_arr['message']['chat']['id'],'title'=>$chat_arr['message']['chat']['title'],'uid'=>$commd[1]]);
                          $telegram->runCommands(['/bind']);
                      }
                  }
                  break;
              case '/help':
                   $telegram->setCommandConfig('test',[]);
                   $telegram->runCommands(['/test']);
              break;
          }

     }


}