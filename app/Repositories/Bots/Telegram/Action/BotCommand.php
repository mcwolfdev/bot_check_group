<?php

namespace App\Repositories\Bots\Telegram\Action;

use App\Repositories\Bots\Telegram\State\Start;
use WeStacks\TeleBot\Handlers\CommandHandler;

class BotCommand extends CommandHandler
{
    protected static $aliases = ['/help', '/start'];
    protected static $description = '"/help" Что я умею';

    public function handle()
    {
/*        if ($this->update->message->text == '/start'){
            $this->sendMessage([
                'text' => 'Hello, World!',
            ]);
        }*/
        $text = $this->update->message->text;

        switch ($text) {
            case '/help':
                $handler = new Start($this->bot, $this->update);
                $handler->run();
                break;

            default:
                $this->sendMessage([
                    'text' => '🚨 Я не знаю такойкоманды 🚫',
                ]);
        }

    }

}
