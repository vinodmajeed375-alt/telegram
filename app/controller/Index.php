<?php

namespace app\controller;

use app\BaseController;
use GuzzleHttp\Client;

class Index extends BaseController
{
    public function index()
    {
        $apikey = config('cms.api_key');
        $url = 'https://api.telegram.org/bot'.$apikey.'/getWebhookInfo';
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
        ]);
        $body = (string)$response->getBody();
        $body = json_decode($body,true);
        print_r($body);


        echo "<hr/>";
        $apikey = config('cms.api_key_q');
        $url = 'https://api.telegram.org/bot'.$apikey.'/getWebhookInfo';
        $response = $client->request('POST', $url, [
            'verify' => false,
        ]);
        $body = (string)$response->getBody();
        $body = json_decode($body,true);

        var_dump('api_key_q',$body);
    }
}
