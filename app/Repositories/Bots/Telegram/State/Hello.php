<?php


namespace App\Repositories\Bots\Telegram\State;

use App\Repositories\Bots\MainHandler;

class Hello extends MainHandler
{

    public function run()
    {
        $this->sendChatAction([
            'action' => 'typing'
        ]);

        $response = new \stdClass();
        $response->text = 'Hi '.$this->update->user()->first_name;

        $messageParams = [
            'chat_id' => $this->update->message->chat->id,
            'text' => $response->text,
        ];

        $this->bot->sendMessage($messageParams);


    }

    public function processCallback(){
        return true;
    }

}
