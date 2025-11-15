<?php


namespace app\controller;


use app\BaseController;
use think\facade\App;

class Test extends BaseController
{

    public function index(){

         $obj =   new Telegramhash(App::getInstance());
         $file_id = "AgACAgUAAxkBAAIYSWkMWcIsDJE9mnjJHGyz4aa2lJXSAAIeDGsbbWtgVCwR3sCfLAJOAQADAgADcwADNgQ";
         $obj->index($file_id,$mgs='32423432');
     }
}