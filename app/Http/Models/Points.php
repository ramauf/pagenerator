<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $table = 'points';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'cities_id',
        'coord',
        'address',
    ];
    public static function getInfo($id){
        return Points::where('id', $id)->first();
    }
    public static function addRow($data){
        if (isset($data['id'])){//UPDATE
            $row = Points::find($data['id']);
        }else{//INSERT
            $row = new Points();
        }
        $row->cities_id = $data['cities_id'];
        $row->coord = $data['coord'];
        $row->address = $data['address'];
        $row->save();
    }
    public static function getRandomPoint($cities_id = 0){
        //Выбрать адрес в любом городе, кроме указанного
        $res = DB::select('SELECT * FROM `points` WHERE `cities_id` != ? ORDER BY RAND() LIMIT 1', [$cities_id]);
        return $res;
    }

}




