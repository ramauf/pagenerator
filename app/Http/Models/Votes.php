<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    protected $table = 'votes';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'users_id',
        'createdTime',
        'rate',
    ];
    public static function getInfo($id){
        return Votes::where('id', $id)->first();
    }
    public static function getVotes($users_id){
        //Выбрать оценки одного или нескольких пользователей
        if (!is_array($users_id)) $users_id = [$users_id];
        $res = DB::select('SELECT * FROM `votes` WHERE `users_id` IN('.implode(',', $users_id).')');
        $vote = [];
        foreach ($res as $row){
            if (!isset($vote[$row->users_id])) $vote[$row->users_id] = ['cnt' => 0, 'avg' => 0];
            $vote[$row->users_id]['cnt'] += 1;
            $vote[$row->users_id]['avg'] += $row->rate;
        }
        foreach ($vote as $ind => $val){
            $vote[$ind]['avg'] = round($val['avg']/$val['cnt'], 1);
        }
        return $vote;
    }
    public static function setVote($users_id = 0, $rate = -1, $limit = 1){
        //Задать (рандомную) оценку (рандомному) пользователю
        //$rate = 0..9
        if ($users_id == 0){
            //$user = Users::getRandomUsers()[0];
            $users = Users::getUsers(['isRand' => '', 'limit' => $limit]);
            foreach ($users as $user){
                if ($rate == -1) $rate = rand(3, 9);
                DB::insert('INSERT INTO `votes` (`users_id`, `createdTime`, `rate`) VALUES (?, ?, ?)', [$user->id, time(), $rate]);
            }
        }else {
            if ($rate == -1) $rate = rand(3, 9);
            DB::insert('INSERT INTO `votes` (`users_id`, `createdTime`, `rate`) VALUES (?, ?, ?)', [$users_id, time(), $rate]);
        }
    }
}
