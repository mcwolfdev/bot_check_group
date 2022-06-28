<?php

namespace App\Repositories\Bots;

use App\Models\TelegramBotContext;
use App\Repositories\Bots\Telegram\State\Hello;
use App\Repositories\Bots\Telegram\State\Films;
use App\Repositories\Bots\Telegram\State\Start;

use WeStacks\TeleBot\Interfaces\UpdateHandler;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;

class MainHandler extends UpdateHandler
{
    protected $telegram_name;
    protected $telegram_id;
    protected $context;
    protected $states;

    public function applyState($context)
    {
        TelegramBotContext::where('telegram_id', $this->update->user()->id)->update(["state" => $context]);
    }

    public function getState(){
        $paramContext = TelegramBotContext::where('telegram_id', $this->update->user()->id)->first();

        if (empty($paramContext->state) || $paramContext->state == null){
            TelegramBotContext::create([
                'telegram_id' => $this->update->user()->id,
                'state' => 'start',
            ]);
            return $paramContext->state;
        }
        return $paramContext->state;
    }

    public static function trigger(Update $update, TeleBot $bot): bool
    {
        //return true;
        return $update->message->text ?? null === 'message';
    }

    public function handle()
    {

        switch ($this->getState()) {
            case 'start':
                $handler = new Start($this->bot, $this->update);
                break;
            case 'Films':
                $handler = new Films($this->bot, $this->update);
                break;

            default:
                $handler = new Hello($this->bot, $this->update);
        }

/*        $piec = explode(" ", $this->update->message->text);
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
        }*/


        //$handler = new Films($this->bot, $this->update);

        try {
            if (isset($this->update->message)) $handler->run();
        } catch (\Exception $e) {

        }


    }


}
