<?php

namespace App\Repositories\Bots;

use App\Http\Controllers\AddGroup;
use App\Http\Controllers\Films;
use App\Http\Controllers\Start;
use WeStacks\TeleBot\Interfaces\UpdateHandler;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;

class MainHandler extends UpdateHandler
{
    protected $telegram_name;
    protected $telegram_id;

    public static function trigger(Update $update, TeleBot $bot): bool
    {
        //return true;
        return $update->message->text ?? null === 'message';
    }

    public function handle()
    {
        $piec = explode(" ", $this->update->message->text);
        $telegram_id = $this->update->user()->id;
        $telegram_name = $this->update->user()->first_name;
        $handler = new Start($this->bot,$this->update);
        $handler->run();

        if (isset($this->update->message->text)) {
            if ($piec[0] == '/del_group') {
                $hand = new AddGroup($this->bot,$this->update);
                if ((empty(is_numeric($piec[1]) == 1))){
                    $this->sendMessage([
                        'text' => $this->update->user()->first_name."! Вы не верно ввели команду",
                    ]);
                    return;
                }
                $hand->del($piec[1]);
            }
        }


        $handler = new Films($this->bot, $this->update);

        try {
            if (isset($this->update->message)) $handler->run();
        } catch (\Exception $e) {

        }
/*        $imdb = new IMDb;
        $ii = $imdb->search($this->update->message->text);

        //$imdb->film("tt0816692");
        if (count($ii['titles']) == ''){
            $this->sendMessage([
                'text' => "❌ Ничего немогу найти",
                'parse_mode' => 'html',
                'disable_web_page_preview'=>'true'
            ]);
        }

        $content = file_get_contents("https://5175.svetacdn.in/api/short?api_token=aweBOf82QqD7VmrLckAsF8y5U13PgzkG&imdb_id=".$ii['titles'][0]['id']);
        $DecContent = json_decode($content, true);

        //echo $DecContent['data'][0]['iframe_src'];

        $this->sendPhoto([
            'photo' => $ii['titles'][0]['image'],
            //'caption' => $ii['titles'][0]['title'].'>>'.$ii['titles'][0]['id'],
            'caption' => $ii['titles'][0]['title']."\n".$DecContent['data'][0]['iframe_src'],
        ]);*/


    }


}
