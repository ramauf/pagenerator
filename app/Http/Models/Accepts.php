<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Accepts extends Model
{
    protected $table = 'accepts';
    public $timestamps = false;
    protected $fillable = [
        'users_id',
        'posts_id',
        'time',
        'uniq'
    ];
    public static function accept($count, $percent){//Занять места в машинке
        $posts = Posts::getUnacceptedPosts($count);//Посты со свободными местами
        foreach ($posts as $post){
            if (rand(1, round(100/$percent)) == 1){//С определенной вероятностью
                self::add([
                    'users_id' => $post->users_id,
                    'posts_id' => $post->id,
                    'status' => 'accepted'
                ]);
            }
        }
    }
    public static function add($data){
        if (!isset($data['status'])) $data['status'] = 'wait';
        DB::insert('INSERT INTO `accepts` (`users_id`, `posts_id`, `time`, `uniq`, `status`) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `uniq` = `uniq`', [
            $data['users_id'],
            $data['posts_id'],
            time(),
            md5($data['users_id'].'-'.$data['posts_id']),
            $data['status']
        ]);
    }
}
