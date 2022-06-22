<?php

namespace App\Repositories\Bots;

use App\Http\Controllers\AddGroup;
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
    }


}

