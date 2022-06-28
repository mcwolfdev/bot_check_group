<?php

namespace App\Repositories\Bots\Telegram\Action;

use App\Repositories\Bots\Telegram\State\Start;
use WeStacks\TeleBot\Handlers\CommandHandler;

class BotCommand extends CommandHandler
{
    protected static $aliases = ['/help'];
    protected static $description = '"/help" Что я умею';

    public function handle()
    {
/*        $this->sendMessage([
            'text' => 'Hello, World!',
        ]);*/
        $handler = new Start($this->bot, $this->update);
        $handler->run();
    }

}
