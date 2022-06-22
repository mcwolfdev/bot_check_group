<?php

namespace Database\Seeders;

use App\Models\TeleGruop;
use Illuminate\Database\Seeder;
class AllSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (TeleGruop::all()->count()==0){
            TeleGruop::create(['name'=>'Sto','link'=>'https://t.me/stotest', 'gruop_id'=>'-1001787643645']);
        }

    }
}
