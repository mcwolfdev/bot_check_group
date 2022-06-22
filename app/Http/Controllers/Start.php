<?php

namespace App\Http\Controllers;

use App\Models\TeleGruop;
use App\Repositories\Bots\MainHandler;

class Start extends MainHandler
{

    private function check_in_group($group_id, $user_id)
    {
        $in_group = false;
        try{
            $answer = $this->bot->getChatMember([
                'user_id' => $user_id,
                'chat_id' => $group_id
            ]);
            if ($answer->status!='left'){
                $in_group = $group_id;
            }
        }catch (\Exception $e){
            $in_group = $group_id;
            return;
            //return $in_group;
        }
        return $in_group;
    }


    public function run()
    {
        foreach (TeleGruop::all() as $group){
            $check = $this->check_in_group($group->gruop_id, $this->update->user()->id);

            if (!$this->check_in_group($group->gruop_id, $this->update->user()->id)){
                $this->sendMessage([
                    'text' => "Здравствуйте, ".$this->update->user()->first_name."! Для того, чтобы пользоваться ботом, нужно подписаться на паблик(и): "."\n".$this->channels($group->gruop_id, $this->update->user()->id),
                ]);
                return;
            }
        }

        $this->sendChatAction([
            'action' => 'typing'
        ]);

        $this->sendMessage([
            'text'=>"🤖 <b>Бот#</b> 🤖

<i>Это тестовый бот</i>",
            'parse_mode'=>'html'
        ]);
    }

    public function channels($group_id, $user_id)
    {
        $res = '';

        foreach (TeleGruop::all() as $AllGroup) {
            if (TeleGruop::all()->count() > 1) {
                if ($this->check_in_group($AllGroup->gruop_id, $this->update->user()->id)){
                    $res = $res.'✅'.$AllGroup->name.' ';
                }elseif (!$this->check_in_group($AllGroup->gruop_id, $this->update->user()->id)){
                    $res = $res.'❌'.$AllGroup->name.' ';
                }
            }
        }
        return $res;
    }
}
