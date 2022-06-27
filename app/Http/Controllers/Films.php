<?php

namespace App\Http\Controllers;

use App\Repositories\Bots\MainHandler;
use hmerritt\Imdb;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;
use WeStacks\TeleBot\Objects\Keyboard;

class Films extends MainHandler
{
    public function run()
    {
        $imdb = new IMDb;
        $ii = $imdb->search($this->update->message->text);

        if (count($ii['titles']) == '' || $ii['titles'] == null){
            $this->sendMessage([
                'text' => "❌ Ничего немогу найти &ldquo;".$ii.'&rdquo;',
                'parse_mode' => 'html',
                'disable_web_page_preview'=>'true'
            ]);
        }

        $content = file_get_contents("https://5175.svetacdn.in/api/short?api_token=".env('VIDEOAPI_TOKEN')."&imdb_id=".$ii['titles'][0]['id']);
        $DecContent = json_decode($content, true);

        //echo $DecContent['data'][0]['iframe_src'];
        $replyOptions['inline_keyboard'][] = [
            new InlineKeyboardButton([
                'text' => "👀 Смотреть",
                'url' => $DecContent['data'][0]['iframe_src'],
            ]),
        ];

        $this->sendPhoto([
            'photo' => $ii['titles'][0]['image'],
            //'caption' => $ii['titles'][0]['title'].'>>'.$ii['titles'][0]['id'],
            'caption' => $ii['titles'][0]['title'],
            'reply_markup' => Keyboard::create($replyOptions)
        ]);
    }

}
