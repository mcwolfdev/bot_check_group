<?php

namespace App\Http\Controllers;

use App\Models\TeleGruop;
use App\Repositories\Bots\MainHandler;

class AddGroup extends MainHandler
{

    public function run()
    {
        $piec = explode(" ", $this->update->message->text);
        if (isset($this->update->message->text)) {
            if ($piec[0] == '/add_group') {
                if (empty($piec[1]) || empty($piec[2]) || empty($piec[3])){
                    $this->sendMessage([
                        'text' => $this->update->user()->first_name."! Вы не верно ввели команду",
                    ]);
                    return;
                }
                TeleGruop::create([
                    'name' => $piec[1],
                    'link' => $piec[2],
                    'gruop_id' => $piec[3]
                ]);
            }
        }
    }

    public function del($group)
    {
        $piec = explode(" ", $this->update->message->text);
            if ($piec[0] == '/del_group') {
                echo $piec[0].' '.$piec[1];
/*                if (empty(is_numeric($piec[1]) == 1)){
                    $this->sendMessage([
                        'text' => $this->update->user()->first_name."! Вы не верно ввели команду ",
                    ]);
                    return;
                }*/
                $del = TeleGruop::find($group);
                if (empty($del)) {
                    $this->sendMessage([
                        'text' => "💥 Неверный ID",
                    ]);
                    return;
                }
                $del->delete();
                $this->sendMessage([
                    'text' => "👏 Запись ID:".$group.' удалена',
                ]);
            }

    }
}
