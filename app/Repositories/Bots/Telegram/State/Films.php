<?php

namespace App\Repositories\Bots\Telegram\State;

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

        if (count($ii['titles']) == 0){ //count($ii['titles']) == '' ||
            $this->sendMessage([
                'text' => "❌ Немогу найти 🔍".$this->update->message->text,
                'parse_mode' => 'html',
                'disable_web_page_preview'=>'true'
            ]);
            return;
        }

        $content = file_get_contents("https://5175.svetacdn.in/api/short?api_token=".env('VIDEOAPI_TOKEN')."&imdb_id=".$ii['titles'][0]['id']);
        $DecContent = json_decode($content, true);

        if (empty($DecContent['data']) || $DecContent['data'] == null){
            return;
        }

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

/*        foreach($ii['titles'] as $i => $item) {
            $content = file_get_contents("https://5175.svetacdn.in/api/short?api_token=".env('VIDEOAPI_TOKEN')."&imdb_id=".$ii['titles'][$i]['id']);
            $DecContent = json_decode($content, true);


            //echo $DecContent['data'][0]['iframe_src'];
            $replyOptions['inline_keyboard'][] = [
                new InlineKeyboardButton([
                    'text' => "👀 Смотреть",
                    //'url' => $DecContent['data'][$i]['iframe_src'],
                ]),
            ];

            $title = $ii['titles'][$i]['title'];
            $image = $ii['titles'][$i]['image'];
            $id = $ii['titles'][$i]['id'];
            echo $title;
            $this->sendPhoto([
                'photo' => $ii['titles'][$i]['image'],
                //'caption' => $ii['titles'][0]['title'].'>>'.$ii['titles'][0]['id'],
                'caption' => $ii['titles'][$i]['title'],
                'reply_markup' => Keyboard::create($replyOptions)
            ]);
        }*/

    }

}
